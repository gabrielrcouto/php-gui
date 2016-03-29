<?php

namespace Gui\Ipc;

use Gui\Application;
use Gui\Output;
use React\Stream\Stream;

class Receiver
{
    public $application;
    public $messageCallbacks = [];

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
     * Process Stdout handler
     * @param  String $data Data received
     */
    public function onData($data)
    {
        $data = self::removeDebug(self::splitMessage($data));

        foreach ($data as $json) {
            Output::out(self::prepareOutput($json));
            $message = self::jsonDecode($json);

            // Can be a command or a result
            if ($message && property_exists($message, 'id')) {
                if (property_exists($message, 'result')) {
                    $this->callMessageCallback($message->id, $message->result);
                } else {
                    // @TODO: Command implementation
                }
            }

            // This is a notification/event!
            if ($message && ! property_exists($message, 'id')) {
                if ($message->method == 'callObjectEventListener') {
                    // @TODO: Check if params contains all the items
                    $this->callObjectEventListener($message->params[0], $message->params[1]);
                }
            }
        }
    }

    protected static function splitMessage($message)
    {
        $data = trim($message);

        if (empty($data)) {
            return [];
        }

        $data = array_filter(array_map(
            function ($data) {
                if ($data[0] !== '{') {
                    $data = '{' . $data;
                }
                if ($data[strlen($data) - 1] !== '}') {
                    $data = $data . '}';
                }

                return $data;
            },
            explode('}{', $data)
        ));

        return $data;
    }

    protected static function removeDebug(array $jsons)
    {
        return array_filter(
            array_map(
                function ($message) {
                    $obj = self::jsonDecode($message);
                    if (property_exists($obj, 'debug')) {
                        Output::out('Debug: ' . $message, 'blue');
                        return null;
                    }

                    return $message;
                },
                $jsons
            )
        );
    }

    protected static function jsonDecode($json)
    {
        $obj = json_decode($json);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $obj;
        } else {
            // @todo throw an exception
            Output::err('JSON ERROR: ' . $json);
        }
    }

    public static function waitMessage(Stream $stdout, MessageInterface $message)
    {
        $buffer = [];

        $stdout->pause();
        $stream = $stdout->stream;
        while (! feof($stream)) {
            $data = fgets($stream);

            if (! empty($data)) {
                $data = self::removeDebug(self::splitMessage($data));

                foreach ($data as $json) {
                    Output::out(self::prepareOutput($json));
                    $obj = self::jsonDecode($json);

                    // Can be a command or a result
                    if (property_exists($obj, 'id')) {
                        if (property_exists($obj, 'result')) {
                            if ($obj->id == $message->id) {
                                $return = $obj->result;
                                break;
                            } else {
                                $buffer[] = $obj;
                                Output::out('Skipped: ' . $obj->id, 'yellow');
                            }
                        }
                    }
                }
            }
            if (isset($return)) {
                break;
            }
        }

        $stdout->resume();

        foreach ($buffer as $json) {
            Output::out('Skipped Sent: ' . $json->id, 'yellow');
            $stdout->emit(
                'data',
                [
                    json_encode($json),
                    $stdout
                ]
            );
        }

        return $return;
    }

    private static function prepareOutput($string)
    {
        return 'Received: ' . $string;
    }
}
