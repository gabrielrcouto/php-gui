<?php

namespace Gui\Components;

use Gui\Application;
use Gui\Ipc\IpcMap;

/**
 * This is the Object class
 *
 * It is base abstraction for Lazarus Object
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
abstract class Object implements LazarusObjectInterface
{
    /**
     * The lazarus class as int
     *
     * @var int $lazarusClass
     */
    protected $lazarusClass = 0;

    /**
     * The communication object id
     *
     * @var int $lazarusObjectId
     */
    protected $lazarusObjectId;

    /**
     * The application object
     *
     * @var Application $application
     */
    protected $application;

    /**
     * The array of callbacks
     *
     * @var array $eventHandlers
     */
    protected $eventHandlers = [];

    /**
     * The array of special properties
     *
     * @var array $runTimeProperties
     */
    protected $runTimeProperties = [];

    /**
     * The constructor
     *
     * @param array $defaultAttributes
     * @param ContainerObjectInterface $parent
     * @param Application $application
     *
     * @return void
     */
    public function __construct(
        array $defaultAttributes = [],
        ContainerObjectInterface $parent = null,
        $application = null
    ) {
        $object = $this;

        // We can use multiple applications, but, if no one is defined, we use the
        // first (default)
        if ($application == null) {
            $this->application = Application::$defaultApplication;
        } else {
            $this->application = $application;
        }

        if ($parent == null) {
            $parent = $this->application->getWindow();
        }

        // Get the next object id
        $this->lazarusObjectId = $this->application->getNextObjectId();
        $this->application->addObject($this);

        if ($this->lazarusObjectId !== 0) {
            if ($this instanceof VisualObjectInterface) {
                $parent->appendChild($this);
            }

            $this->application->sendMessage(
                [
                    IpcMap::ROOT_METHOD_ID_KEY => IpcMap::COMMAND_METHOD_CREATE_OBJECT,
                    IpcMap::ROOT_PARAMS_KEY => [
                        IpcMap::PARAMS_OBJECT_ID_KEY => $this->lazarusObjectId,
                        IpcMap::PARAMS_OBJECT_CLASS_KEY => $this->lazarusClass,
                        IpcMap::PARAMS_PARENT_ID_KEY => $parent->getLazarusObjectId(),
                    ]
                ],
                function ($result) use ($object, $defaultAttributes) {
                    foreach ($defaultAttributes as $attr => $value) {
                        $method = 'set' . ucfirst($attr);
                        if (method_exists($object, $method)) {
                            $object->$method($value);
                        }
                    }
                }
            );
        }
    }

    /**
     * The special method used to do the getters/setters for special properties
     *
     * @param string $method
     * @param array $params
     *
     * @return self|mixed
     */
    public function __call($method, $params)
    {
        $type = substr($method, 0, 3);
        $rest = lcfirst(substr($method, 3));

        switch ($type) {
            case 'get':
                if (isset($this->runTimeProperties[$rest])) {
                    return $this->runTimeProperties[$rest];
                }
                break;

            case 'set':
                $this->runTimeProperties[$rest] = $params[0];
                return $this;
                break;

            default:
                # do nothing
                break;
        }
    }

    /**
     * This method is used to send an object command/envent to lazarus
     *
     * @param int$method
     * @param array $params
     *
     * @return void
     */
    protected function call($method, array $params = [])
    {
        $params[IpcMap::PARAMS_OBJECT_ID_KEY] = $this->lazarusObjectId;
        $params[IpcMap::PARAMS_OBJECT_METHOD_NAME_KEY] = $method;
        $this->application->sendMessage([
            IpcMap::ROOT_METHOD_ID_KEY => IpcMap::COMMAND_METHOD_CALL_OBJECT_METHOD,
            IpcMap::ROOT_PARAMS_KEY => $params
        ]);
    }

    /**
     * this method is used to send the IPC message when a property is set
     *
     * @param string $name  Property name
     * @param mixed $value Property value
     *
     * @return void
     */
    protected function set($name, $value)
    {
        $this->application->sendMessage([
            IpcMap::ROOT_METHOD_ID_KEY => IpcMap::COMMAND_METHOD_SET_OBJECT_PROPERTY,
            IpcMap::ROOT_PARAMS_KEY => [
                IpcMap::PARAMS_OBJECT_ID_KEY => $this->lazarusObjectId,
                IpcMap::PARAMS_OBJECT_PROPERTY_NAME_KEY => $name,
                IpcMap::PARAMS_OBJECT_PROPERTY_VALUE_KEY => $value,
            ]
        ]);
    }

    /**
     * This magic method is used to send the IPC message when a property is get
     *
     * @param string $name Property name
     *
     * @return mixed
     */
    protected function get($name)
    {
        return $this->application->waitMessage([
            IpcMap::ROOT_METHOD_ID_KEY => IpcMap::COMMAND_METHOD_GET_OBJECT_PROPERTY,
            IpcMap::ROOT_PARAMS_KEY => [
                IpcMap::PARAMS_OBJECT_ID_KEY => $this->lazarusObjectId,
                IpcMap::PARAMS_OBJECT_PROPERTY_NAME_KEY => $name,
            ]
        ]);
    }

    /**
    * {@inheritdoc}
    */
    public function getLazarusObjectId()
    {
        return $this->lazarusObjectId;
    }

    /**
    * {@inheritdoc}
    */
    public function getLazarusClass()
    {
        return $this->lazarusClass;
    }

    /**
    * {@inheritdoc}
    */
    public function fire($eventName)
    {
        if (array_key_exists($eventName, $this->eventHandlers)) {
            foreach ($this->eventHandlers[$eventName] as $eventHandler) {
                $eventHandler();
            }
        }
    }

    /**
    * {@inheritdoc}
    */
    public function on($eventName, callable $eventHandler)
    {
        $eventName = 'on' . $eventName;

        $this->application->sendMessage(
            [
                IpcMap::ROOT_METHOD_ID_KEY => IpcMap::COMMAND_METHOD_SET_OBJECT_EVENT_LISTENER,
                IpcMap::ROOT_PARAMS_KEY => [
                    IpcMap::PARAMS_OBJECT_ID_KEY => $this->lazarusObjectId,
                    IpcMap::PARAMS_EVENT_NAME_KEY => $eventName,
                ]
            ],
            function ($result) {
                // Ok, the event listener created
            }
        );

        if (! array_key_exists($eventName, $this->eventHandlers)) {
            $this->eventHandlers[$eventName] = [];
        }

        $this->eventHandlers[$eventName][] = $eventHandler;
    }
}
