<?php

namespace Gui\Components;

use Gui\Application;
use Gui\Color;

/**
 * This is the Button Class
 *
 * It is a visual component for button
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
abstract class Object
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
     * @param Object $parent
     * @param Application $application
     *
     * @return void
     */
    public function __construct(array $defaultAttributes = [], Object $parent = null, $application = null)
    {
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
     * Fire an object event
     *
     * @param string $eventName Event Name
     *
     * @return void
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
     * Add a listener to an event
     *
     * @param string $eventName Event Name
     * @param callable $eventHandler Event Handler Function
     *
     * @return void
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

    /**
     * Get the auto size
     *
     * @return Boolean
     */
    public function getAutoSize()
    {
        return $this->get('color');
    }

    /**
     * Set the auto size
     *
     * @param Boolean $autoSize True = Enabled
     *
     * @return self
     */
    public function setAutoSize($autoSize)
    {
        $this->set('autosize', $autoSize);

        return $this;
    }

    /**
     * Get the background color
     *
     * @return String
     */
    public function getBackgroundColor()
    {
        return $this->get('color');
    }

    /**
     * Set the background Color
     *
     * @param string $color Color '#123456'
     *
     * @return self
     */
    public function setBackgroundColor($color)
    {
        $this->set('color', Color::toLazarus($color));

        return $this;
    }

    /**
     * Gets the value of bottom in pixel.
     *
     * @return int
     */
    public function getBottom()
    {
        return $this->get('bottom');
    }

    /**
     * Sets the value of bottom in pixel.
     *
     * @param int $bottom the bottom
     *
     * @return self
     */
    public function setBottom($bottom)
    {
        $this->set('bottom', $bottom);

        return $this;
    }

    /**
     * Gets the value of height in pixel.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->get('height');
    }

    /**
     * Sets the value of height in pixel.
     *
     * @param int $height the height
     *
     * @return self
     */
    public function setHeight($height)
    {
        $this->set('height', $height);

        return $this;
    }

    /**
     * Gets the value of lazarusObjectId.
     *
     * @return mixed
     */
    public function getLazarusObjectId()
    {
        return $this->lazarusObjectId;
    }

    /**
     * Gets the value of lazarusClass.
     *
     * @return mixed
     */
    public function getLazarusClass()
    {
        return $this->lazarusClass;
    }

    /**
     * Gets the value of left in pixel.
     *
     * @return int
     */
    public function getLeft()
    {
        return $this->get('left');
    }

    /**
     * Sets the value of left in pixel.
     *
     * @param int $left the left
     *
     * @return self
     */
    public function setLeft($left)
    {
        $this->set('left', $left);

        return $this;
    }

    /**
     * Gets the value of right in pixel.
     *
     * @return int
     */
    public function getRight()
    {
        return $this->get('right');
    }

    /**
     * Sets the value of right in pixel.
     *
     * @param int $right the right
     *
     * @return self
     */
    public function setRight($right)
    {
        $this->set('right', $right);

        return $this;
    }

    /**
     * Gets the value of top in pixel.
     *
     * @return int
     */
    public function getTop()
    {
        return $this->get('top');
    }

    /**
     * Sets the value of top in pixel.
     *
     * @param int $top the top
     *
     * @return self
     */
    public function setTop($top)
    {
        $this->set('top', $top);

        return $this;
    }

    /**
     * Gets the value of width in pixel.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->get('width');
    }

    /**
     * Sets the value of width in pixel.
     *
     * @param int $width the width
     *
     * @return self
     */
    public function setWidth($width)
    {
        $this->set('width', $width);

        return $this;
    }

    /**
     * Gets the value of visible in pixel.
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->get('visible');
    }

    /**
     * Sets the value of visible in pixel.
     *
     * @param boolean $visible the visible
     *
     * @return self
     */
    public function setVisible($visible)
    {
        $this->set('visible', $visible);

        return $this;
    }
}
