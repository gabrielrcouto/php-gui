<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\InputText;
use Gui\Components\Shape;

$application = new Application();

$application->on('start', function() use ($application) {
    $button = (new Button())
        ->setCounter(1)
        ->setLeft(100)
        ->setTop(100)
        ->setValue('Dont click');

    $input = (new InputText())
        ->setLeft(10)
        ->setValue('Made with PHP S2!')
        ->setTop(50)
        ->setWidth(290);

    $button->on('click', function() use ($button, $input) {
        $button->setValue('Ouch ' . $button->getCounter() . 'x');
        $button->setCounter($button->getCounter() + 1);

        if ($button->getCounter() >= 20) {
            $text = 'Please, stop! You already clicked ' . preg_replace('/[^0-9]/', '', $button->getValue()) . ' times';
            $input->setValue($text);
        }

        if ($button->getCounter() == 30) {
            $button->setVisible(false);
        }
    });
});

$application->run();
