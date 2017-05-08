<?php
/*
 * Password Input Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\Button;
use Gui\Components\InputPassword;

$application = new Application();

$application->on('start', function() use ($application) {
    $label = (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Password:')
        ->setTop(20);

    $field = (new InputPassword())
        ->setLeft(90)
        ->setTop(16)
        ->setWidth(200)
    ;

    $button = (new Button())
        ->setCounter(1)
        ->setLeft(10)
        ->setTop(50)
        ->setValue('Click me, or Return/Enter in the above field')
        ->setWidth(300);

    $func = function() use ($application, $field) {
        $application->alert('Password: ' . $field->getValue(), 'Password');
    };

    $button->on('click', $func);

    $field->on('EditingDone', $func);
});

$application->run();
