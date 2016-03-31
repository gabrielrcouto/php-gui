<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\Canvas;

$application = new Application([
    'title' => 'My PHP Desktop Application',
    'left' => 248,
    'top' => 50,
    'width' => 860,
    'height' => 600
]);

$application->on('start', function() use ($application) {
    $button = (new Button())
        ->setCounter(1)
        ->setLeft(100)
        ->setTop(100)
        ->setValue('Dont click');

    $button->on('click', function() use ($button) {
        $button->setCounter($button->getCounter() + 1);
        $button->setValue('Click' . $button->getCounter());
    });

    $canvas = new Canvas([
        'top' => 0,
        'left' => 0,
        'width' => 100,
        'height' => 100
    ]);

    $canvas->setSize(100, 100);

    for ($x = 0; $x < 100; $x++) {
        for ($y = 0; $y < 100; $y++) {
            $canvas->setPixel($x, $y, '#ff0000');
        }
    }
});

$application->run();
