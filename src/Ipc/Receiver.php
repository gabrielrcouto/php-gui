<?php

namespace Gui\Ipc;

use Gui\Application;
use Gui\Exception\ComponentException;
use Gui\OsDetector;
use Gui\Output;
use React\Stream\Stream;

/**
 * This is the Receiver class.
 *
 * This class is used to receive communication messages
 *
 * @author Gabriel Couto @gabrielrcouto
 *
 * @since 0.1
 */
class Receiver
{
    /**
     * The application object.
     *
     * @var Application
     */
    public $application;

    /**
     * The buffer of received messages.
     *
     * @var string
     */
    protected $buffer = '';

    /**
     * Array of callbacks.
     *
     * @var array
     */
    public $messageCallbacks = [];

    /**
     * Defines if is waiting message.
     *
     * @var bool
     */
    protected $isWaitingMessage = false;

    /**
     * Array of messages in buffer.
     *
     * @var array
     */
    protected $parseMessagesBuffer = [];

    /**
     * The id of the waitingMessage.
     *
     * @var int
     */
    protected $waitingMessageId;

    /**
     * The return of the waitingMessage.
     *
     * @var mixed
     */
    protected $waitingMessageResult;

    /**
     * The constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * When the result of a message arrives, we call a callback.
     *
     * @param int      $id       Message ID
     * @param callable $callback Callback function
     */
    public function addMessageCallback($id, callable $callback)
    {
        $this->messageCallbacks[$id] = $callback;
    }

    /**
     * Fire a event on a object.
     *
     * @param int    $id        Object ID
     * @param string $eventName Event Name
     */
    public function callObjectEventListener($id, $eventName)
    {
        $object = $this->application->getObject($id);

        if ($object) {
            $object->fire($eventName);
        }
    }

    /**
     * Result received, time to call the message callback.
     *
     * @param int                     $id     Message ID
     * @param string|array|object|int $result Command Result
     */
    public function callMessageCallback($id, $result)
    {
        if (array_key_exists($id, $this->messageCallbacks)) {
            $this->messageCallbacks[$id]($result);
            unset($this->messageCallbacks[$id]);
        }
    }

    /**
     * Decode a received message.
     *
     * @param string $json Received json message
     *
     * @return MessageInterface|void
     *
     * @throws ComponentException
     */
    protected function jsonDecode($json)
    {
        $obj = @json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $strErr = 'JSON ERROR: '.$json;
            if ($this->application->getVerboseLevel() == 2) {
                Output::err($strErr);
            }
            throw new ComponentException($strErr);
        }

        return $obj;
    }

    /**
     * Process Stdout handler.
     *
     * @param string $data Data received
     */
    public function onData($data)
    {
        // Fix to Windows event problem where the data wasn't being NULL terminated.
        if (substr($data, strlen($data) - 2, 1) !== "\0") {
            $data .= "\0";
        }

        // Add the new messages to the buffer
        $this->buffer .= $data;

        // Find the NULL character position
        $nulPos = strpos($this->buffer, "\0");

        while ($nulPos !== false) {
            $messageJson = substr($this->buffer, 0, $nulPos);
            $message = $this->jsonDecode($messageJson);

            $this->buffer = substr($this->buffer, $nulPos + 1);

            // Now, process the message
            if ($message) {
                if ($this->application->getVerboseLevel() == 2) {
                    Output::out($this->prepareOutput($messageJson), 'green');
                }

                if (property_exists($message, 'debug')) {
                    $this->parseDebug($message);
                } else {
                    $this->parseNormal($message);
                }
            }

            $nulPos = strpos($this->buffer, "\0");
        }
    }

    /**
     * Parse a debug message.
     *
     * @param $message Message
     */
    protected function parseDebug($message)
    {
        if ($this->application->getVerboseLevel() == 2) {
            Output::out('<= Debug: '.json_encode($message), 'blue');
        }
    }

    /**
     * Parse a normal message, can be a command, command result or an event.
     *
     * @param $message Message
     */
    protected function parseNormal($message)
    {
        // Can be a command or a result
        if ($message && property_exists($message, 'id')) {
            if (property_exists($message, 'result')) {
                if ($this->isWaitingMessage) {
                    if ($message->id == $this->waitingMessageId) {
                        $this->waitingMessageResult = $message->result;
                        $this->isWaitingMessage = false;
                    } else {
                        $this->parseMessagesBuffer[] = $message;
                    }
                } else {
                    $this->callMessageCallback($message->id, $message->result);
                }
            } else {
                // @todo: Command implementation
            }

            return;
        }

        // It's waiting a message? Store for future parsing
        if ($this->isWaitingMessage) {
            $this->parseMessagesBuffer[] = $message;

            return;
        }

        // This is a notification/event!
        if ($message && !property_exists($message, 'id')) {
            if ($message->method == 'callObjectEventListener') {
                // @todo: Check if params contains all the items
                $this->callObjectEventListener($message->params[0], $message->params[1]);
            }
        }
    }

    /**
     * Construct the output string.
     *
     * @param string $string Output string
     *
     * @return string New output string
     */
    protected function prepareOutput($string)
    {
        return '<= Received: '.$string;
    }

    /**
     * Read the stdout pipe from Lazarus process. This function uses
     * stream_select to be non blocking.
     */
    public function tick()
    {
        $stream = $this->application->process->stdout->stream;
        $read = [$stream];
        $write = [];
        $except = [];

        $result = stream_select($read, $write, $except, 0);

        if ($result === false) {
            throw new \Exception('stream_select failed');
        }

        if ($result === 0) {
            return;
        }

        // This solves a bug on Windows - If you read the exact size (> 1),
        // PHP will block
        if (OsDetector::isWindows()) {
            $status = fstat($stream);

            if ($status['size'] > 0) {
                $size = $status['size'];

                if ($size > 1) {
                    --$size;

                    $data = stream_get_contents($stream, $size);
                    $data .= stream_get_contents($stream, 1);
                } else {
                    $data = stream_get_contents($stream, 1);
                }

                $this->application->process->stdout->emit('data', array($data, $this));
            }
        } else {
            // On Linux and OSX, we don't need to pass a size limit
            $data = stream_get_contents($stream);

            if (!empty($data)) {
                $this->application->process->stdout->emit('data', array($data, $this));
            }
        }
    }

    /**
     * Wait a message result.
     *
     * @param Stream           $stdout  Stdout Stream
     * @param MessageInterface $message Command waiting result
     *
     * @return mixed The result
     */
    public function waitMessage(Stream $stdout, MessageInterface $message, Application $application)
    {
        $buffer = [];

        $this->waitingMessageId = $message->id;
        $this->isWaitingMessage = true;

        // Read the stdin until we get the message replied
        while ($this->isWaitingMessage && $application->isRunning()) {
            $this->tick();
            usleep(1);
        }

        //$stdout->resume();

        $result = $this->waitingMessageResult;
        $this->waitingMessageResult = null;

        foreach ($this->parseMessagesBuffer as $key => $message) {
            $this->parseNormal($message);
        }

        $this->parseMessagesBuffer = [];

        return $result;
    }
}
