<?php

namespace Gui\Ipc;

use Gui\Application;
use Gui\Output;
use React\Stream\Stream;
use Gui\OsDetector;

class Receiver
{
    public $application;
    protected $buffer = '';
    public $messageCallbacks = [];
    protected $isWaitingMessage = false;
    protected $parseMessagesBuffer = [];
    protected $waitingMessageId;
    protected $waitingMessageResult;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * When the result of a message arrives, we call a callback
     * @param int $id       Message ID
     * @param function $callback Callback function
     */
    public function addMessageCallback($id, $callback)
    {
        $this->messageCallbacks[$id] = $callback;
    }

    /**
     * Fire a event on a object
     * @param  int $id Object ID
     * @param  String $eventName Event Name
     */
    public function callObjectEventListener($id, $eventName)
    {
        $object = $this->application->getObject($id);

        if ($object) {
            $object->fire($eventName);
        }
    }

    /**
     * Result received, time to call the message callback
     * @param  int $id Message ID
     * @param  String|Array|Object|int $result Command Result
     */
    public function callMessageCallback($id, $result)
    {
        if (array_key_exists($id, $this->messageCallbacks)) {
            $this->messageCallbacks[$id]($result);
            unset($this->messageCallbacks[$id]);
        }
    }

    /**
     * Decode a received message
     * @param  String $json Received json message
     * @return MessageInterface       Message
     */
    protected function jsonDecode($json)
    {
        $obj = json_decode($json);

        if ($obj !== null) {
            return $obj;
        } else {
            // @todo throw an exception
            if ($this->application->getVerboseLevel() == 2) {
                Output::err('JSON ERROR: ' . $json);
            }
        }
    }

    /**
     * Process Stdout handler
     * @param  String $data Data received
     */
    public function onData($data)
    {
        // Add the new messages to the buffer
        $this->buffer .= $data;

        $openingBraces = 0;
        $closingBraces = 0;
        $doubleQuotes = 0;
        $firstOpeningBracePos = 0;

        $currentPos = 0;
        $bufferLength = strlen($this->buffer);

        for ($i = 0; $i < $bufferLength; $i++) {
            if ($this->buffer[$currentPos] == '{' && $doubleQuotes % 2 == 0) {
                if ($openingBraces == 0) {
                    $firstOpeningBracePos = $currentPos;
                }

                $openingBraces++;
            } elseif ($this->buffer[$currentPos] == '}' && $doubleQuotes % 2 == 0) {
                $closingBraces++;
            } elseif ($this->buffer[$currentPos] == '"'
                && ($currentPos == 0
                || $this->buffer[$currentPos - 1] != '\\')) {
                // We are opening or closing a JSON string?
                $doubleQuotes++;
            }

            $currentPos++;

            if ($openingBraces > 0 && $openingBraces == $closingBraces) {
                $messageJson = substr($this->buffer, $firstOpeningBracePos, $currentPos);
                $message = $this->jsonDecode($messageJson);

                // First, remove the message from the buffer
                if ($currentPos > strlen($this->buffer)) {
                    $this->buffer = '';
                } else {
                    $this->buffer = substr($this->buffer, $currentPos);
                }

                $currentPos = 0;
                $openingBraces = 0;
                $closingBraces = 0;
                $doubleQuotes = 0;

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
            }
        }
    }

    /**
     * Parse a debug message
     * @param  MessageInterface $message Message
     */
    protected function parseDebug($message)
    {
        if ($this->application->getVerboseLevel() == 2) {
            Output::out('<= Debug: ' . json_encode($message), 'blue');
        }
    }

    /**
     * Parse a normal message, can be a command, command result or an event
     * @param  MessageInterface $message Message
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
                // @TODO: Command implementation
            }

            return;
        }

        // It's waiting a message? Store for future parsing
        if ($this->isWaitingMessage) {
            $this->parseMessagesBuffer[] = $message;
            return;
        }

        // This is a notification/event!
        if ($message && ! property_exists($message, 'id')) {
            if ($message->method == 'callObjectEventListener') {
                // @TODO: Check if params contains all the items
                $this->callObjectEventListener($message->params[0], $message->params[1]);
            }
        }
    }

    /**
     * Construct the output string
     * @param  String $string Output string
     * @return String         New output string
     */
    protected function prepareOutput($string)
    {
        return '<= Received: ' . $string;
    }

    /**
     * Read the stdout pipe from Lazarus process. This function uses
     * stream_select to be non blocking
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

        if (OsDetector::isUnix()) {
            $this->application->process->stdout->handleData($stream);
        } else {
            $status = fstat($stream);

            if ($status['size'] > 0) {
                $size = $status['size'];

                if ($size > 1) {
                    $size -= 1;
                    // This solves a bug on Windows - If you read the exact size (> 1),
                    // PHP will block
                    $data = stream_get_contents($stream, $size);
                    $data .= stream_get_contents($stream, 1);
                } else {
                    $data = stream_get_contents($stream, 1);
                }

                $this->application->process->stdout->emit('data', array($data, $this));
            }
        }
    }

    /**
     * Wait a message result
     * @param  Stream           $stdout  Stdout Stream
     * @param  MessageInterface $message Command waiting result
     * @return Mixed                    The result
     */
    public function waitMessage(Stream $stdout, MessageInterface $message)
    {
        $buffer = [];

        $this->waitingMessageId = $message->id;
        $this->isWaitingMessage = true;

        // Read the stdin until we get the message replied
        while ($this->isWaitingMessage) {
            $this->tick();
            usleep(1);
        }

        $stdout->resume();

        $result = $this->waitingMessageResult;
        $this->waitingMessageResult = null;

        foreach ($this->parseMessagesBuffer as $key => $message) {
            $this->parseNormal($message);
        }

        $this->parseMessagesBuffer = [];

        return $result;
    }
}
