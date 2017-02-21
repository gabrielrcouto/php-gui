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
        ->setTop(80);

    $field = (new InputDate())
        ->setLeft(100)
        ->setTop(80)
        ->setWidth(200)
        ->setValue('01/01/2017')
        ->setDialogOptions(InputDate::SHOW_WEEK_NUMBERS)
    ;

    $field->on('change', function() use ($application, $field) {
        if(strlen($field->getValue()) === 10){
            $application->alert($field->getValue(), 'Date selected');
        }
    });
});

$application->run();
