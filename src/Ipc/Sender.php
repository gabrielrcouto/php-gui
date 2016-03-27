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
        $this->processMessage($message);
        $json = $this->getLazarusJson($message);
        $this->output($json);

        if (is_callable($message->callback)) {
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
        $this->output($json);

        $this->application->process->stdin->write($json);
        $this->application->process->stdout->pause();

        $this->application->process->stdin->getBuffer()->handleWrite();

        $stream = $this->application->process->stdout->stream;
        while (! feof($stream)) {
            $data = fgets($stream);

            if (! empty($data)) {
                $return = $this->processReturn($data);
                if ($return !== false) {
                    $this->application->process->stdout->resume();
                    break;
                }
            }
        }

        return $return;
    }

    private function processReturn($data)
    {
        echo 'Received: ' . $data . PHP_EOL;

        if (strlen($data) === 0) {
            return;
        }

        if ($data[0] === '{' && $data[strlen($data) - 1] === '}') {
            $message = json_decode($data);

            // Can be a command or a result
            if ($message && property_exists($message, 'id')) {
                if (property_exists($message, 'result')) {
                    return $message->result;
                }
            }
        }

        return false;
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

    private function output($json)
    {
        echo 'Sent: ' . $json . PHP_EOL;
    }
}
