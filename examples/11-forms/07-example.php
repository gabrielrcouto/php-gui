<?php
/*
 * Calendar Example
 */

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Calendar;

$application = new Application();

$application->on('start', function () use ($application) {
    $field = (new Calendar())
        ->setLeft(20)
        ->setTop(20)
        ->setValue('01/02/2017')
    ;

    // {on}change events is also fired with the getValue() and then causes a infinite loop
    $field->on('mouseUp', function () use ($application, $field) {
        $application->alert('Date selected: ' . $field->getValue(), 'Date selected');
    });
});

$application->run();
