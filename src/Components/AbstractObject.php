<?php

namespace Gui\Components;

use Gui\Application;

/**
 * This is the Object class
 *
 * It is base abstraction for Lazarus Object
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
abstract class AbstractObject implements LazarusObjectInterface
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TObject';

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
            // Send the createObject command
            $this->application->sendCommand(
                'createObject',
                [
                    [
                        'lazarusClass' => $this->lazarusClass,
                        'lazarusObjectId' => $this->lazarusObjectId,
                        'parent' => $parent->getLazarusObjectId()
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
     * @param string $method
     * @param array $params
     * @param boolean $isCommand
     *
     * @return void
     */
    protected function call($method, array $params, $isCommand = true)
    {
        if ($isCommand) {
            // It's a command
            $this->application->sendCommand(
                'callObjectMethod',
                [
                    $this->lazarusObjectId,
                    $method,
                    $params
                ],
                function ($result) {
                    // Ok, the property changed
                }
            );

            return;
        }

        // It's a event
        $this->application->sendEvent(
            'callObjectMethod',
            [
                $this->lazarusObjectId,
                $method,
                $params
            ]
        );
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
        $this->application->sendCommand(
            'setObjectProperty',
            [
                $this->lazarusObjectId,
                $name,
                $value
            ],
            function ($result) {
                // Ok, the property changed
            }
        );
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
        return $this->application->waitCommand('getObjectProperty', [
            $this->lazarusObjectId,
            $name
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

        $this->application->sendCommand('setObjectEventListener', [
            $this->lazarusObjectId,
            $eventName
        ], function ($result) {
            // Ok, the event listener created
        });

        if (! array_key_exists($eventName, $this->eventHandlers)) {
            $this->eventHandlers[$eventName] = [];
        }

        $this->eventHandlers[$eventName][] = $eventHandler;
    }
}
