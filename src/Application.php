<?php

namespace Gui;

use Gui\Ipc\CommandMessage;
use Gui\Ipc\Sender;
use React\ChildProcess\Process;
use React\EventLoop\Factory;

class Application
{
    public static $defaultApplication;
    protected $eventHandlers = [];
    protected $loop;
    public $process;
    protected $running = false;
    protected $sender;

    public function fire($eventName)
    {
        if (array_key_exists($eventName, $this->eventHandlers)) {
            foreach ($this->eventHandlers[$eventName] as $eventHandler) {
                $eventHandler();
            }
        }
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
        $this->process = $process = new Process('./phpgui', __DIR__ . '/../lazarus/phpgui.app/Contents/MacOS/');
        $this->sender = new Sender($this);

        $this->loop->addTimer(0.001, function($timer) use ($process, $application) {
            $process->start($timer->getLoop());

            $process->stdout->on('data', function($output) use ($process) {
                echo 'Output: ' . $output;
            });

            $application->running = true;

            // Bootstrap the application
            $application->fire('start');
        });

        $this->loop->run();
    }

    public function sendCommand($method, $params)
    {
        // @TODO: Put the message on a poll
        if (! $this->running) {
            return;
        }

        $message = new CommandMessage($method, $params);
        $this->sender->send($message);
    }
}