<?php

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Button;

$application = new Application([
    'title' => 'Destroying objects',
    'width' => 500,
]);

$application->on('start', function () use ($application) {
    $button = (new Button())
        ->setToggle(true)
        ->setLeft(10)
        ->setTop(200)
        ->setValue('I\'ll destroy myself!')
        ->setWidth(480);

    $button2 = (new Button())
        ->setLeft(10)
        ->setTop(50)
        ->setValue('Click here to manipulate the button below.')
        ->setWidth(480);

    $button2->on('click', function () use ($button, $application) {
        $button = $application->getObject($button->getLazarusObjectId());

        $prepend = $button->getToggle() ? 'foo' : 'bar';
        $button->setToggle(! $button->getToggle());
        $button->setValue($prepend . ' - I\'ll destroy myself!');
    });

    $button->on('click', function () use ($button2, $button, $application) {
        $button2->setValue('If you click now, it will crash!');
        $application->destroyObject($button);
    });
});

$application->run();
