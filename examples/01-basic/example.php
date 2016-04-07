<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\InputText;
use Gui\Components\Label;
use Gui\Components\Shape;

$application = new Application();

$application->on('start', function() use ($application) {
    $label = (new Label())
        ->setFontSize(20)
        ->setLeft(90)
        ->setText('Basic Example')
        ->setTop(10);

    $button = (new Button())
        ->setCounter(1)
        ->setLeft(10)
        ->setTop(80)
        ->setValue('Hey, I\'m a button! Please, don\'t click me')
        ->setWidth(300);

    $input = (new InputText())
        ->setLeft(10)
        ->setValue('This input was made with PHP S2!')
        ->setTop(50)
        ->setWidth(300);

    $phrases = [
        'Ouch, I said "Don\'t click me"',
        'Ok, stop',
        'Please!',
        'What you doing?',
        'Nice, I know, you have a mouse',
        'Yep, with the mouse you can click',
        'Formating C:',
        'Yeah, was a joke',
        'Do you know about PHP-SP?',
        'Drink coke',
        'Click to skip this ad',
    ];

    $button->on('click', function() use ($button, $input, $phrases) {
        $counter = $button->getCounter();
        $button->setCounter(++$counter);

        if ($counter < 10) {
            $input->setValue($phrases[$counter - 1]);
        } elseif ($counter < 20) {
            $input->setValue('Please, stop! You already clicked ' . $counter . ' times');
        } elseif ($counter == 20) {
            $input->setValue('Hehe, click again!');
            $button->setVisible(false);
        }

        if ($counter < 10) {
            $counter = '0' . $counter;
        }

        $color = $counter * (1.0 / 6);

        $r = (int)(3 * sin($color) + 3);
        $g = (int)(3 * sin($color + 2 * (M_PI / 3)) + 3);
        $b = (int)(3 * sin($color + 4 * (M_PI / 3)) + 3);

        $color = '#' . dechex($r) . dechex($g) . dechex($b);

        $shape = (new Shape())
            ->setBackgroundColor($color)
            ->setBorderColor($color)
            ->setHeight($counter * 5)
            ->setLeft($counter * 10)
            ->setTop(120)
            ->setWidth($counter * 5);
    });
});

$application->run();
