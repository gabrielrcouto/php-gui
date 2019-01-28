<?php

namespace Gui;

use Gui\Components\AbstractObject;
use Gui\Components\Window;
use Gui\Ipc\CommandMessage;
use Gui\Ipc\EventMessage;
use Gui\Ipc\Receiver;
use Gui\Ipc\Sender;
use React\ChildProcess\Process;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;

/**
 * This class is used to manipulate the application
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Application
{
    /**
     * The application object.
     *
     * @var Application
     */
    public static $defaultApplication;

    /**
     * The object responsible to manage the lazarus process.
     *
     * @var Process
     */
    public $process;

    /**
     * The internal array of all callbacks.
     *
     * @var array
     */
    protected $eventHandlers = [];

    /**
     * The application loop.
     *
     * @var LoopInterface
     */
    protected $loop;

    /**
     * The next object ID available.
     *
     * @var int
     */
    protected $objectId = 0;

    /**
     * The internal array of all Components Objects in this application.
     *
     * @var array
     */
    protected $objects = [];

    /**
     * Defines if the application is running.
     *
     * @var bool
     */
    protected $running = false;

    /**
     * The responsible object to sent the communication messages.
     *
     * @var Sender
     */
    protected $sender;

    /**
     * The responsible object to receive the communication messages.
     *
     * @var Receiver
     */
    protected $receiver;

    /**
     * The verbose level.
     *
     * @var int
     */
    protected $verboseLevel = 2;

    /**
     * The 1st Window of the Application.
     *
     * @var Window
     */
    protected $window;

    /**
     * The constructor method.
     *
     * @param LoopInterface $loop
     */
    public function __construct(array $defaultAttributes = [], LoopInterface $loop = null)
    {
        $this->window = $window = new Window([], null, $this);
        $this->loop = $loop ?: Factory::create();

        $this->on('start', function () use ($window, $defaultAttributes) {
            foreach ($defaultAttributes as $attr => $value) {
                $method = 'set'.\ucfirst($attr);
                if (\method_exists($window, $method)) {
                    $window->{$method}($value);
                }
            }
        });
    }

    /**
     * Unset the object referency from the stack.
     *
     * @param $objectId
     */
    public function __unset($objectId)
    {
        if ($this->getObject($objectId)) {
            unset($this->objects[$objectId]);
        }
    }

    /**
     * Returns the 1st Window of the Application.
     *
     * @return Window
     */
    public function getWindow()
    {
        return $this->window;
    }

    /**
     * Returns the communication time between php and lazarus.
     *
     * @return float
     */
    public function ping()
    {
        $now = \microtime(true);
        $this->waitCommand(
            'ping',
            [
                (string) $now,
            ]
        );

        return \microtime(true) - $now;
    }

    /**
     * Put a object to the internal objects array.
     *
     * @param AbstractObject $object Component Object
     */
    public function addObject(AbstractObject $object)
    {
        $this->objects[$object->getLazarusObjectId()] = $object;
    }

    /**
     * Destroy a object.
     *
     * @param AbstractObject $object Component Object
     */
    public function destroyObject(AbstractObject $object)
    {
        $application = $this;

        $this->sendCommand(
            'destroyObject',
            [
                $object->getLazarusObjectId(),
            ],
            function ($result) use (&$object, $application) {
                if ($result == $object->getLazarusObjectId()) {
                    if ($application->getObject($result)) {
                        unset($object, $application->{$result});
                    }
                }
            }
        );
    }

    /**
     * Fire an application event.
     *
     * @param string $eventName Event Name
     */
    public function fire($eventName)
    {
        if (\array_key_exists($eventName, $this->eventHandlers)) {
            foreach ($this->eventHandlers[$eventName] as $eventHandler) {
                $eventHandler();
            }
        }
    }

    /**
     * Returns the next avaible object ID.
     *
     * @return int
     */
    public function getNextObjectId()
    {
        return $this->objectId++;
    }

    /**
     * Get a object from the internal objects array.
     *
     * @param int $id Object ID
     *
     * @return object
     */
    public function getObject($id)
    {
        return (isset($this->objects[$id]) && null !== $this->objects[$id]) ? $this->objects[$id] : null;
    }

    /**
     * Returns the verbose level.
     *
     * @return int
     */
    public function getVerboseLevel()
    {
        return $this->verboseLevel;
    }

    /**
     * Returns the next avaible object ID.
     *
     * @param string   $eventName    the name of the event
     * @param callable $eventHandler the callback
     */
    public function on($eventName, callable $eventHandler)
    {
        if (!\array_key_exists($eventName, $this->eventHandlers)) {
            $this->eventHandlers[$eventName] = [];
        }

        $this->eventHandlers[$eventName][] = $eventHandler;
    }

    /**
     * Runs the application.
     */
    public function run()
    {
        if (!self::$defaultApplication) {
            self::$defaultApplication = $this;
        }

        $application = $this;

        if (OsDetector::isMacOS()) {
            $processName = './phpgui-i386-darwin';
            $processPath = __DIR__.'/../lazarus/phpgui-i386-darwin.app/Contents/MacOS/';
        } elseif (OsDetector::isFreeBSD()) {
            $processName = './phpgui-x86_64-freebsd';
            $processPath = __DIR__.'/../lazarus/';
        } elseif (OsDetector::isUnix()) {
            switch (OsDetector::systemArchitecture()) {
                case 'x86_64':
                    $processName = './phpgui-x86_64-linux';
                    break;
                case 'i686':
                case 'i586':
                case 'i386':
                    $processName = './phpgui-i386-linux';
                    break;
                default:
                    throw new \RuntimeException('Operational System architecture not identified by PHP-GUI.');
                    break;
            }
            $processPath = __DIR__.'/../lazarus/';
        } elseif (OsDetector::isWindows()) {
            $processName = '.\\phpgui-x86_64-win64';
            $processPath = __DIR__.'\\..\\lazarus\\';
        } else {
            throw new \RuntimeException('Operational System not identified by PHP-GUI.');
        }

        $this->process = $process = new Process($processName, $processPath);

        $this->process->on('exit', function () use ($application) {
            $application->fire('exit');
            $application->running = false;
            $application->loop->stop();
        });

        $this->receiver = $receiver = new Receiver($this);
        $this->sender = $sender = new Sender($this, $receiver);

        $this->loop->addTimer(0.001, function ($timer) use ($process, $application, $receiver) {
            $process->start($timer->getLoop());

            // We need to pause all default streams
            // The react/loop uses fread to read data from streams
            // On Windows, fread always is blocking

            // Stdin is paused, we use our own way to write on it
            $process->stdin->pause();
            // Stdout is paused, we use our own way to read it
            $process->stdout->pause();
            // Stderr is paused for avoiding fread
            $process->stderr->pause();

            $process->stdout->on('data', function ($data) use ($receiver) {
                $receiver->onData($data);
            });

            $process->stderr->on('data', function ($data) {
                if (!empty($data)) {
                    Output::err($data);
                }
            });

            $application->running = true;

            // Bootstrap the application
            $application->fire('start');
        });

        $this->loop->addPeriodicTimer(0.001, function () use ($process, $application) {
            if (!$application->isRunning()) {
                $application->terminate();
            }

            $application->sender->tick();

            if (@\is_resource($application->process->stdout->stream)) {
                $application->receiver->tick();
            }
        });

        $this->loop->run();
    }

    /**
     * Terminates the application.
     */
    public function terminate()
    {
        $this->sendCommand('exit', [], function () {
        });
        @$this->process->terminate();
        @$this->process->close();
    }

    /**
     * Send a command.
     *
     * @param string   $method   the method name
     * @param array    $params   the method params
     * @param callable $callback the callback
     */
    public function sendCommand($method, array $params, callable $callback)
    {
        // @todo: Put the message on a poll
        if (!$this->running) {
            return;
        }

        $message = new CommandMessage($method, $params, $callback);
        $this->sender->send($message);
    }

    /**
     * Send an event.
     *
     * @param string $method the method name
     * @param array  $params the method params
     */
    public function sendEvent($method, array $params)
    {
        // @todo: Put the message on a poll
        if (!$this->running) {
            return;
        }

        $message = new EventMessage($method, $params);
        $this->sender->send($message);
    }

    /**
     * Set the verbose level.
     *
     * @param int $verboseLevel
     */
    public function setVerboseLevel($verboseLevel)
    {
        $this->verboseLevel = $verboseLevel;
    }

    /**
     * Send a command and wait the return.
     *
     * @param string $method the method name
     * @param array  $params the method params
     *
     * @return mixed
     */
    public function waitCommand($method, array $params)
    {
        $message = new CommandMessage($method, $params);

        return $this->sender->waitReturn($message);
    }

    /**
     * Get the event loop.
     *
     * @return LoopInterface
     */
    public function getLoop()
    {
        return $this->loop;
    }

    /**
     * Shows an alert dialog.
     *
     * @param mixed  $message Array or String message to display
     * @param string $title   Title of the alert
     */
    public function alert($message, $title = '')
    {
        if (\is_array($message)) {
            $message = \implode('\n', $message);
        }
        $this->sendCommand(
            'showMessage',
            [$message, $title],
            function ($result) {
                // Dummy
            }
        );
    }

    /**
     * Gets the Defines if the application is running.
     *
     * @return bool $running
     */
    public function isRunning()
    {
        $this->running = !$this->process->isRunning() ? false : $this->running;

        return $this->running;
    }
}
