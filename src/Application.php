<?php

namespace Gui;

use Gui\Components\Window;
use Gui\Ipc\CommandMessage;
use Gui\Ipc\EventMessage;
use Gui\Ipc\Receiver;
use Gui\Ipc\Sender;
use Gui\OsDetector;
use React\ChildProcess\Process;
use React\EventLoop\Factory;

class Application
{
    public static $defaultApplication;
    protected $eventHandlers = [];
    public $loop;
    protected $objectId = 0;
    protected $objects = [];
    public $process;
    protected $running = false;
    protected $sender;
    protected $verboseLevel = 2;
    protected $window;

    public function __construct(array $defaultAttributes = [])
    {
        $this->window = $window = new Window([], null, $this);

        $this->on('start', function () use ($window, $defaultAttributes) {
            foreach ($defaultAttributes as $attr => $value) {
                $method = 'set' . ucfirst($attr);
                if (method_exists($window, $method)) {
                    $window->$method($value);
                }
            }
        });
    }

    public function getWindow()
    {
        return $this->window;
    }

    public function ping()
    {
        $now = microtime(true);
        $this->waitCommand(
            'ping',
            [
                (string) $now
            ]
        );

        return microtime(true) - $now;
    }

    /**
     * Put a object to the internal objects array
     * @param Object $object Component Object
     */
    public function addObject($object)
    {
        $this->objects[$object->getLazarusObjectId()] = $object;
    }

    /**
     * Fire an application event
     * @param  String $eventName Event Name
     */
    public function fire($eventName)
    {
        if (array_key_exists($eventName, $this->eventHandlers)) {
            foreach ($this->eventHandlers[$eventName] as $eventHandler) {
                $eventHandler();
            }
        }
    }

    /**
     * Returns the next avaible object ID
     */
    public function getNextObjectId()
    {
        return $this->objectId++;
    }

    /**
     * Get a object from the internal objects array
     * @param int $id Object ID
     */
    public function getObject($id)
    {
        // @TODO: Check if the object exists
        return $this->objects[$id];
    }

    public function getVerboseLevel()
    {
        return $this->verboseLevel;
    }

    public function on($eventName, $eventHandler)
    {
        if (! array_key_exists($eventName, $this->eventHandlers)) {
            $this->eventHandlers[$eventName] = [];
        }

        $this->eventHandlers[$eventName][] = $eventHandler;
    }

    public function run()
    {
        if (! self::$defaultApplication) {
            self::$defaultApplication = $this;
        }

        $application = $this;
        $this->loop = Factory::create();

        if (OsDetector::isMacOS()) {
            $processName = './phpgui-i386-darwin';
            $processPath = __DIR__ . '/../lazarus/phpgui-i386-darwin.app/Contents/MacOS/';
        } elseif (OsDetector::isUnix()) {
            $processName = './phpgui-x86_64-linux';
            $processPath = __DIR__ . '/../lazarus/';
        } elseif (OsDetector::isWindows()) {
            $processName = '.\\phpgui-x86_64-win64';
	    $processPath = __DIR__ . '\\..\\lazarus\\';
        } else {
            throw new RuntimeException('Operational System not identified by PHP-GUI.');
        }

        $this->process = $process = new Process($processName, $processPath);

        $this->receiver = $receiver = new Receiver($this);
        $this->sender = new Sender($this, $receiver);

        $this->loop->addTimer(0.001, function ($timer) use ($process, $application, $receiver) {
            $process->start($timer->getLoop());

            $process->stdout->on('data', function ($data) use ($receiver) {
                $receiver->onData($data);
            });

            $process->stderr->on('data', function ($data) {
                if (! empty($data)) {
                    Output::err($data);
                }
            });

            $application->running = true;

            // Bootstrap the application
            $application->fire('start');
        });

        $this->loop->run();
    }

    public function sendCommand($method, $params, $callback)
    {
        // @TODO: Put the message on a poll
        if (! $this->running) {
            return;
        }

        $message = new CommandMessage($method, $params, $callback);
        $this->sender->send($message);
    }

    public function sendEvent($method, $params)
    {
        // @TODO: Put the message on a poll
        if (! $this->running) {
            return;
        }

        $message = new EventMessage($method, $params);
        $this->sender->send($message);
    }

    public function setVerboseLevel($verboseLevel)
    {
        $this->verboseLevel = $verboseLevel;
    }

    public function waitCommand($method, $params)
    {
        $message = new CommandMessage($method, $params);

        return $this->sender->waitReturn($message);
    }
}
