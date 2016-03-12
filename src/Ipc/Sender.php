<?php

namespace Gui\Ipc;

use Gui\Application;

class Sender
{
    public $application;
    public $lastId = 0;
    public $receiver;

    public function __construct(Application $application, Receiver $receiver)
    {
        $this->application = $application;
        $this->receiver = $receiver;
    }

    public function send(MessageInterface $message)
    {
        if (property_exists($message, 'id')) {
            $message->id = $this->lastId++;

            // It's a command!
            $this->receiver->addMessageCallback($message->id, $message->callback);
        }

        $json = json_encode($message);

        // Escape }{ for message spliting on Lazarus
        $json = str_replace('}{', '}\{', $json);

        echo $json . PHP_EOL;

        $this->application->process->stdin->write($json);
    }
}