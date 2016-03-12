<?php

namespace Gui\Components;

use Gui\Application;

class Object
{
    protected $application;
    protected $lazarusClass = 'TObject';
    protected $lazarusObjectId;

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
        $this->lazarusObjectId = $this->application->getNextObjectId();

        // Send the createObject command
        // As the callback, we will define the object id
        $this->application->sendCommand('createObject', [
            [
                'lazarusClass' => $this->lazarusClass
            ]
        ], function($result) use ($object) {
            $object->onCreated($result);
        });
    }

    public function __set($name, $value)
    {
        // @TODO - Check on a property list if we need to send the
        // command to Lazarus
        $this->application->sendCommand('setObjectProperty', [
            $this->lazarusObjectId,
            $name,
            $value
        ], function($result) {
            // Ok, the property changed :-)
        });

        $this->$name = $value;
    }

    public function onCreated($lazarusObjectId)
    {
        // Store the object ID from lazarus
        $this->lazarusObjectId = $lazarusObjectId;
    }
}