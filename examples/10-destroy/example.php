<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\Label;

$application = new Application([
    'title' => 'Destroying objects',
    'width' => 500,
]);

$application->on('start', function() use ($application) {
    $button = (new Button())
        ->setCounter(1)
        ->setLeft(10)
        ->setTop(200)
        ->setValue('I\'ll destroy myself!')
        ->setWidth(480);

    $button2 = (new Button())
        ->setCounter(1)
        ->setLeft(10)
        ->setTop(50)
        ->setValue('Click here to manipulate the button below.')
        ->setWidth(480);

    $odd = true;
    $button2->on('click', function() use ($button, & $odd) {
        $prepend = $odd ? 'foo' : 'bar';
        $odd = !$odd;
        $button->setValue($prepend . ' - I\'ll destroy myself!');
    });

    $button->on('click', function() use ($button, $application) {
        $application->destroyObject($button);
    });
});

$application->run();
