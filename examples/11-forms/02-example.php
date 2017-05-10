<?php
/*
 * File Field Example
 */

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\OpenOptions;
use Gui\Components\InputFile;

$application = new Application();

$application->on('start', function() use ($application) {
    $field = (new InputFile())
        ->setLeft(10)
        ->setTop(50)
        ->setWidth(300)
        ->setBaseDir(realpath(__DIR__.'/../..'))
        ->setDialogOptions(InputFile::ALLOW_MULTI_SELECT)
    ;

    $field->on('change', function() use ($application, $field) {
        $application->alert('Files: ' . PHP_EOL . implode(PHP_EOL, $field->getValue()), 'Files');
    });
});

$application->run();
