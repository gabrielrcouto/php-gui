<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\Canvas;

$application = new Application([
    'title' => 'My PHP Desktop Application',
    'left' => 248,
    'top' => 50,
    'width' => 100,
    'height' => 200
]);

$application->on('start', function() use ($application) {
    $button = (new Button())
        ->setCounter(1)
        ->setLeft(10)
        ->setTop(150)
        ->setValue('Dont click');

    $canvas = new Canvas([
        'top' => 0,
        'left' => 0,
        'width' => 100,
        'height' => 100
    ]);

    $canvas->setSize(100, 100);

    for ($x = 50; $x >= 0; $x--) {
        for ($y = 0; $y < 100; $y++) {
            $canvas->setPixel($x, $y, '#ff0000');
        }
    }

    $button->on('click', function() use ($canvas) {
        if ($canvas->getDone() !== true) {
            $canvas->setDone(true);
            for ($x = 100; $x >= 51; $x--) {
                for ($y = 0; $y < 100; $y++) {
                    $canvas->setPixel($x, $y, '#0000ff');
                }
            }
        }
    });
});

$application->run();
