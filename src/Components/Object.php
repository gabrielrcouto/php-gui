<?php

namespace Gui\Components;

use Gui\Application;

class Object
{
    protected $application;
    protected $lazarusClass = 'TObject';

    public function __construct($defaultAttributes = null, $application = null)
    {
        if ($application == null) {
            $this->application = Application::$defaultApplication;
        } else {
            $this->application = $application;
        }

        $this->application->sendCommand('createObject', [
            [
                'lazarusClass' => $this->lazarusClass
            ]
        ], $this);
    }

    public function onCreated($id)
    {

    }
}