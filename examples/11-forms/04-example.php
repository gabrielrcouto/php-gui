<?php
/*
 * Number Input Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\InputNumber;

$application = new Application();

$application->on('start', function() use ($application) {
    $label1 = (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Integer')
        ->setTop(80);

    $field1 = (new InputNumber())
        ->setLeft(100)
        ->setTop(80)
        ->setWidth(200)
        ->setIncrement(2)
        ->setMax(10)
        ->setMin(-10)
        ->setValue(-4)
    ;

    $label2 = (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Float')
        ->setTop(120);

    $field2 = (new InputNumber(true))
        ->setLeft(100)
        ->setTop(120)
        ->setWidth(200)
        ->setIncrement(0.25)
        ->setValue(1.25)
        ->setDecimals(4)
    ;

});

$application->run();
