<?php
/*
 * Date Input Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\InputTime;

$application = new Application();

$application->on('start', function() use ($application) {
    $label = (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Time')
        ->setTop(80);

    $field = (new InputTime())
        ->setLeft(100)
        ->setTop(80)
        ->setWidth(200)
        ->setAcceptInput(false)
        ->setButtonOnlyWhenFocused(true)
    ;

    $field->on('change', function() use ($application, $field) {
        if (strlen($field->getValue()) === 5) {
            $application->alert($field->getValue(), 'Time selected');
        }
    });
});

$application->run();
