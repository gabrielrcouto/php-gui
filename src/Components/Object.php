<?php

namespace Gui\Components;

use Gui\Application;

/**
 * Object
 *
 * @property int $bottom Bottom position (in pixels)
 * @property int $height Height size (in pixels)
 * @property int $left Left position (in pixels)
 * @property int $right Right position (in pixels)
 * @property int $top Top position (in pixels)
 * @property int $width Width size (in pixels)
 */
class Object
{
    protected $application;
    protected $bottom;
    protected $eventHandlers = [];
    protected $height;
    protected $left;
    public $lazarusClass = 'TObject';
    public $lazarusObjectId;
    protected $propertiesNameTransform = [];
    protected $right;
    protected $top;
    protected $width;

    public function __construct($defaultAttributes = null, $application = null)
    {
        $object = $this;

        // We can use multiple applications, but, if no one is defined, we use the
        // first (default)
        if ($application == null) {
            $this->application = Application::$defaultApplication;
        } else {
            $this->application = $application;
        }

        // Get the next object id
        $this->application->addObject($this);

        // Send the createObject command
        $this->application->sendCommand('createObject', [
            [
                'lazarusClass' => $this->lazarusClass,
                'lazarusObjectId' => $this->lazarusObjectId,
            ]
        ], function($result) use ($object) {
            // Ok, object created
        });

        // @TODO: Use defaultAttributes for initial properties values
    }

    /**
     * This magic method is used to send the IPC message when a property is set
     * @param String $name  Property name
     * @param mixed $value Property value
     */
    public function __set($name, $value)
    {
        $this->$name = $value;

        // For Lazarus, this property has another name
        if (array_key_exists($name, $this->propertiesNameTransform)) {
            $name = $this->propertiesNameTransform[$name];
        }

        // @TODO: Check on a property list if we need to send the
        // command to Lazarus
        $this->application->sendCommand('setObjectProperty', [
            $this->lazarusObjectId,
            $name,
            $value
        ], function($result) {
            // Ok, the property changed
        });
    }

    /**
     * Fire an object event
     * @param  String $eventName Event Name
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
     * @param  String $eventName Event Name
     * @param  Function $eventHandler Event Handler Function
     */
    public function on($eventName, $eventHandler)
    {
        $eventName = 'on' . $eventName;

        $this->application->sendCommand('setObjectEventListener', [
            $this->lazarusObjectId,
            $eventName
        ], function($result) {
            // Ok, the event listener created
        });

        if (! array_key_exists($eventName, $this->eventHandlers)) {
            $this->eventHandlers[$eventName] = [];
        }

        $this->eventHandlers[$eventName][] = $eventHandler;
    }
}