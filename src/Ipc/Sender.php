<?php

namespace Gui\Ipc;

use Gui\Application;

class Sender
{
    public $application;
    public $lastId = 0;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function send(MessageInterface $message)
    {
        if (property_exists($message, 'id')) {
            $message->id = $this->lastId++;
        }

        $this->application->process->stdin->write(json_encode($message));
    }
}