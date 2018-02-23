<?php

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;

$application = new Application();

$application->on('start', function () use ($application) {
    $application->alert(['Hello World!', 'WhooP!']);
});

$application->run();
