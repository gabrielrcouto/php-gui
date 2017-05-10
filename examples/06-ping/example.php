<?php

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Label;
use Gui\Output;

$application = new Application([
    'title' => 'PHP <=> Lazarus Speed Tester',
    'left' => 248,
    'top' => 50,
    'width' => 400,
    'height' => 200
]);

$application->on('start', function() use ($application) {
    $label = new Label([
        'text' => "See the speed on your terminal. \nThis app measures the speed of" .
            "\nIPC messages between PHP and Lazarus",
        'fontSize' => 20,
        'top' => 10,
        'left' => 10,
    ]);

    $currentSecond = time();
    $messagesPerSecond = 0;

    // Disable application verbose, to see the speed messages
    $application->setVerboseLevel(0);

    $application->getLoop()->addPeriodicTimer(
        0.000001,
        function() use ($application, & $currentSecond, & $messagesPerSecond) {
            $latency = $application->ping();

            if (time() != $currentSecond) {
                Output::out('Speed: ' . $messagesPerSecond . ' messages/sec', 'red');

                $messagesPerSecond = 0;
                $currentSecond = time();
            }

            $messagesPerSecond++;
        }
    );
});

$application->run();
