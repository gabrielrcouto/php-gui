<?php
/*
 * Password Input Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\InputPassword;

$application = new Application();

$application->on('start', function() use ($application) {
    $label = (new Label())
        ->setFontSize(12)
        ->setLeft(10)
        ->setText('Password')
        ->setTop(80);

    $field = (new InputPassword())
        ->setLeft(100)
        ->setTop(80)
        ->setWidth(200)
    ;

    var_dump($field->get('EchoMode'));

    $field->on('EditingDone', function() use ($application, $field) {
        $application->alert($field->getValue(), 'Password');
    });
});

$application->run();
