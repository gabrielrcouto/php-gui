<?php

namespace Gui\Ipc;

use Gui\Application;
use Gui\Output;

/**
 * This is the Sender class
 *
 * This class is used to send communication messages
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Sender
{
    /**
     * The application object
     *
     * @var Application $application
     */
    public $application;

    /**
     * The latest id available
     *
     * @var int $lastId
     */
    public $lastId = 0;

    /**
     * The receiver object
     *
     * @var Receiver $receiver
     */
    public $receiver;

    /**
     * The buffer of messages to be sent
     *
     * @var string $sendLaterMessagesBuffer
     */
    protected $sendLaterMessagesBuffer = '';

    /**
     * The constructor
     *
     * @param Application $application
     * @param Receiver $receiver
     *
     * @return void
     */
    public function __construct(Application $application, Receiver $receiver)
    {
        $this->application = $application;
        $this->receiver = $receiver;
    }

    /**
     * Get a valid Lazarus RPC JSON String
     *
     * @param MessageInterface $message Message to send
     *
     * @return String Lazarus JSON string
     */
    protected function getLazarusJson(MessageInterface $message)
    {
        return json_encode($message);
    }

    /**
     * Print debug information
     *
     * @param String $text Text to print
     *
     * @return void
     */
    protected function out($text)
    {
        if ($this->application->getVerboseLevel() == 2) {
            $re = explode('}{', $text);
            foreach ($re as $key => $value) {
                if (count($re) > 1&& $key == 0) {
                    Output::out('=> Sent: ' . $value . '}', 'yellow');
                } elseif (count($re) > 1 && $key == count($re) - 1) {
                    Output::out('=> Sent: {' . $value, 'yellow');
                } elseif (count($re) > 1) {
                    Output::out('=> Sent: {' . $value . '}', 'yellow');
                } else {
                    Output::out('=> Sent: ' . $value, 'yellow');
                }
            }
        }
    }

    /**
     * Process a message before sending - Useful to incrementing IDs
     *
     * @param MessageInterface $message Message
     *
     * @return void
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
     * @param MessageInterface $message Message to send
     *
     * @return void
     */
    public function send(MessageInterface $message)
    {
        $this->processMessage($message);

        // But into a buffer and send the max we can
        // Each message is terminated by the NULL character
        $this->sendLaterMessagesBuffer .= $this->getLazarusJson($message) . "\r\n";

        if (property_exists($message, 'callback') && is_callable($message->callback)) {
            // It's a command!
            $this->receiver->addMessageCallback($message->id, $message->callback);
        } else {
            // @todo: throw an exception
        }

        $this->writeOnStream();
    }

    /**
     * Send a message and wait for the return
     *
     * @param MessageInterface $message
     *
     * @return mixed The return of the message
     */
    public function waitReturn(MessageInterface $message)
    {
        $this->processMessage($message);

        // Each message is terminated by CRLF
        // Bypass the DuplexResourceStream Buffer, sending direct to the stream
        fwrite($this->application->connection->stream, $this->getLazarusJson($message) . "\r\n");

        return $this->receiver->waitMessage(
            $message,
            $this->application
        );
    }

    /**
     * Write on stdin stream
     *
     * @return void
     */
    protected function writeOnStream()
    {
        if ($this->application->getVerboseLevel() == 2) {
            echo 'Sent => ' . $this->sendLaterMessagesBuffer . PHP_EOL;
        }

        $this->application->connection->write($this->sendLaterMessagesBuffer);
        $this->sendLaterMessagesBuffer = '';
    }
}
