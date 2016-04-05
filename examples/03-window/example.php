<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\Button;

$application = new Application([
    'title' => 'My PHP Desktop Application',
    'left' => 248,
    'top' => 50,
    'width' => 860,
    'height' => 600,
    'icon' => realpath(__DIR__) . DIRECTORY_SEPARATOR . 'php.ico'
]);

$application->on('start', function() use ($application) {

    $label = new Label([
        'text' => 'Manipulating Window',
        'top' => 10,
        'fontSize' => 50,
        'left' => 100,
    ]);

    $button = new Button([
        'value' => 'It\'s too big, click to resize!',
        'top' => 150,
        'left' => 200,
        'width' => 450
    ]);

    $button->on('click', function () use ($button, $application) {
        $window = ($application->getWindow());

        if ($window->getHeight() == 600) {
            $window->setHeight(300);
        } else {
            $window->setHeight(600);
        }

        $button->setCounter($button->getCounter() + 1);
        $button->setValue('Your window was resized ' . $button->getCounter() . ' time(s), click to resize again!');
    });

});

$application->run();
