<?php

namespace Gui\Ipc;

use Gui\Application;
use Gui\Output;

class Sender
{
    public $application;
    public $lastId = 0;
    public $receiver;
    protected $sendLaterMessagesBuffer = [];

    public function __construct(Application $application, Receiver $receiver)
    {
        $this->application = $application;
        $this->receiver = $receiver;
    }

    /**
     * Get a valid Lazarus RPC JSON String
     * @param  MessageInterface $message Message to send
     * @return String                    Lazarus JSON string
     */
    protected function getLazarusJson(MessageInterface $message)
    {
        return json_encode($message);
    }

    /**
     * Check if stdin stream is over the buffer limit
     * @return boolean True if its over
     */
    protected function isStdinOverLimit()
    {
        $status = fstat($this->application->process->stdin->stream);

        if ($status['size'] >= 30000) {
            return true;
        }

        return false;
    }

    /**
     * Print debug information
     *
     * @param  String $text Text to print
     */
    protected function out($text)
    {
        if ($this->application->getVerboseLevel() == 2) {
            Output::out('=> Sent: ' . $text, 'yellow');
        }
    }

    /**
     * Process a message before sending - Useful to incrementing IDs
     *
     * @param  MessageInterface $message Message
     */
    protected function processMessage(MessageInterface $message)
    {
        if (property_exists($message, 'id')) {
            $message->id = $this->lastId++;
        }
    }

    /**
     * Send a message
     *
     * @param  MessageInterface $message Message to send
     */
    public function send(MessageInterface $message)
    {
        $this->processMessage($message);

        // Get the stdin stream length - The max size on Linux and OSX is 65000 bytes
        // We will use a 30000 limit - If it's over this limit, we put on a queue
        if ($this->isStdinOverLimit()) {
            $this->sendLaterMessagesBuffer[] = $message;
            return;
        }

        if (property_exists($message, 'callback') && is_callable($message->callback)) {
            // It's a command!
            $this->receiver->addMessageCallback($message->id, $message->callback);
        } else {
            // @todo throw an exception
        }

        $this->writeOnStream($message);
    }

    /**
     * Check and send queued messages
     */
    public function tick()
    {
        if (count($this->sendLaterMessagesBuffer) > 0) {
            foreach ($this->sendLaterMessagesBuffer as $key => $message) {
                if (! $this->isStdinOverLimit()) {
                    $this->writeOnStream($message);
                    unset($this->sendLaterMessagesBuffer[$key]);
                } else {
                    break;
                }
            }
        }
    }

    /**
     * Send a message and wait for the return
     *
     * @param  MessageInterface $message
     * @return Mixed                    The return of the message
     */
    public function waitReturn(MessageInterface $message)
    {
        $this->processMessage($message);
        $this->writeOnStream($message);

        return $this->receiver->waitMessage(
            $this->application->process->stdout,
            $message
        );
    }

    /**
     * Write on stdin stream, converting a message to a json string
     *
     * @param  MessageInterface $message Message to send
     */
    protected function writeOnStream(MessageInterface $message)
    {
        $json = $this->getLazarusJson($message);

        $this->out($json);

        $this->application->process->stdin->write($json);
        $this->application->process->stdin->getBuffer()->handleWrite();
    }
}
