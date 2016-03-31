<?php

namespace Gui\Ipc;

use Gui\Application;
use Gui\Output;

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
        $this->processMessage($message);
        $json = $this->getLazarusJson($message);

        if ($this->application->getVerboseLevel() == 2) {
            Output::out(self::prepareOutput($json));
        }

        if (property_exists($message, 'callback') && is_callable($message->callback)) {
            // It's a command!
            $this->receiver->addMessageCallback($message->id, $message->callback);
        } else {
            // @todo throw an exception
        }

        $this->application->process->stdin->write($json);
        $this->application->process->stdin->getBuffer()->handleWrite();
    }

    public function waitReturn(MessageInterface $message)
    {
        $this->processMessage($message);
        $json = $this->getLazarusJson($message);

        if ($this->application->getVerboseLevel() == 2) {
            Output::out(self::prepareOutput($json));
        }

        $this->application->process->stdin->write($json);
        $this->application->process->stdin->getBuffer()->handleWrite();

        return $this->receiver->waitMessage(
            $this->application->process->stdout,
            $message
        );
    }

    private function processMessage(MessageInterface $message)
    {
        if (property_exists($message, 'id')) {
            $message->id = $this->lastId++;
        }
    }

    private function getLazarusJson(MessageInterface $message)
    {
        $json = json_encode($message);

        // Escape }{ for message spliting on Lazarus
        $json = str_replace('}{', '}\{', $json);

        return $json;
    }

    private static function prepareOutput($json)
    {
        return 'Sent: ' . $json;
    }
}
