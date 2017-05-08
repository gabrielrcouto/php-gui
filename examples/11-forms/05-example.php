<?php
/*
 * Date Input Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\InputDate;

$application = new Application();

$application->on('start', function() use ($application) {
    $label = (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Date')
        ->setTop(20);

    $field = (new InputDate())
        ->setLeft(90)
        ->setTop(16)
        ->setWidth(200)
    ;

    $field->on('change', function() use ($application, $field) {
        $application->alert('Date selected: ' . $field->getValue(), 'Date selected');
    });
});

$application->run();
