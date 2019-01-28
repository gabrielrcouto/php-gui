<?php

namespace Gui\Ipc;

use Gui\Application;
use Gui\Output;

/**
 * This class is used to send communication messages
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Sender
{
    /**
     * The application object.
     *
     * @var Application
     */
    public $application;

    /**
     * The latest id available.
     *
     * @var int
     */
    public $lastId = 0;

    /**
     * The receiver object.
     *
     * @var Receiver
     */
    public $receiver;

    /**
     * The buffer of messages to be sent.
     *
     * @var string
     */
    protected $sendLaterMessagesBuffer = '';

    /**
     * The constructor.
     */
    public function __construct(Application $application, Receiver $receiver)
    {
        $this->application = $application;
        $this->receiver = $receiver;
    }

    /**
     * Send a message.
     *
     * @param MessageInterface $message Message to send
     */
    public function send(MessageInterface $message)
    {
        $this->processMessage($message);

        // But into a buffer and send the max we can
        // Each message is terminated by the NULL character
        $this->sendLaterMessagesBuffer .= $this->getLazarusJson($message)."\0";

        if (\property_exists($message, 'callback') && \is_callable($message->callback)) {
            // It's a command!
            $this->receiver->addMessageCallback($message->id, $message->callback);
        }
        // @todo: throw an exception

        $this->writeOnStream();
    }

    /**
     * Check and send queued messages.
     */
    public function tick()
    {
        if (\mb_strlen($this->sendLaterMessagesBuffer) > 0) {
            $this->writeOnStream();
        }
    }

    /**
     * Send a message and wait for the return.
     *
     * @return mixed The return of the message
     */
    public function waitReturn(MessageInterface $message)
    {
        $this->processMessage($message);

        // Each message is terminated by the NULL character
        $this->sendLaterMessagesBuffer .= $this->getLazarusJson($message)."\0";
        $this->writeOnStream();

        return $this->receiver->waitMessage(
            $this->application->process->stdout,
            $message,
            $this->application
        );
    }

    /**
     * Get a valid Lazarus RPC JSON String.
     *
     * @param MessageInterface $message Message to send
     *
     * @return string Lazarus JSON string
     */
    protected function getLazarusJson(MessageInterface $message)
    {
        return \json_encode($message);
    }

    /**
     * Print debug information.
     *
     * @param string $text Text to print
     */
    protected function out($text)
    {
        if (2 == $this->application->getVerboseLevel()) {
            $re = \explode('}{', $text);
            foreach ($re as $key => $value) {
                if (\count($re) > 1 && 0 == $key) {
                    Output::out('=> Sent: '.$value.'}', 'yellow');
                } elseif (\count($re) > 1 && $key == \count($re) - 1) {
                    Output::out('=> Sent: {'.$value, 'yellow');
                } elseif (\count($re) > 1) {
                    Output::out('=> Sent: {'.$value.'}', 'yellow');
                } else {
                    Output::out('=> Sent: '.$value, 'yellow');
                }
            }
        }
    }

    /**
     * Process a message before sending - Useful to incrementing IDs.
     *
     * @param MessageInterface $message Message
     */
    protected function processMessage(MessageInterface $message)
    {
        if (\property_exists($message, 'id')) {
            $message->id = $this->lastId++;
        }
    }

    /**
     * Write on stdin stream.
     */
    protected function writeOnStream()
    {
        $stream = $this->application->process->stdin->stream;

        if (\is_resource($stream)) {
            // Send the maximum we can to stream
            $writtenBytes = \fwrite($stream, $this->sendLaterMessagesBuffer);

            if (false === $writtenBytes || 0 === $writtenBytes) {
                // Waiting stdin pipe buffer...
                return;
            }

            if (\mb_strlen($this->sendLaterMessagesBuffer) == $writtenBytes) {
                $this->out($this->sendLaterMessagesBuffer);
                $this->sendLaterMessagesBuffer = '';
            } else {
                $this->out(\mb_substr($this->sendLaterMessagesBuffer, 0, $writtenBytes));
                $this->sendLaterMessagesBuffer = \mb_substr($this->sendLaterMessagesBuffer, $writtenBytes);
            }
        }
    }
}
