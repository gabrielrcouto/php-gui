<?php
/*
 * Calendar Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Calendar;

$application = new Application();

$application->on('start', function() use ($application) {
    $field = (new Calendar())
        ->setLeft(20)
        ->setTop(20)
        ->setValue('01/02/2017')
    ;
    $application->alert($field->getValue(), 'Date selected');
    $field->on('DayChanged', function() use ($application, $field) {
        $application->alert($field->getValue(), 'Date selected');
    });
});

$application->run();
