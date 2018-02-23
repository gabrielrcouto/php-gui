<?php
/*
 * Number Input Example
 */

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\InputNumber;

$application = new Application();

$application->on('start', function () {
    (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Integer')
        ->setTop(80);

    (new InputNumber())
        ->setLeft(100)
        ->setTop(80)
        ->setWidth(200)
        ->setIncrement(2)
        ->setMax(10)
        ->setMin(-10)
        ->setValue(-4)
    ;

    (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Float')
        ->setTop(120);

    (new InputNumber(true))
        ->setLeft(100)
        ->setTop(120)
        ->setWidth(200)
        ->setIncrement(0.25)
        ->setValue(1.25)
        ->setDecimals(4)
    ;
});

$application->run();
