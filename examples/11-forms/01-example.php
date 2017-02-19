<?php

/*
 * Directory Field Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\InputDirectory;

$application = new Application();

$application->on('start', function() use ($application) {
    $field = (new InputDirectory())
        ->setLeft(10)
        ->setTop(80)
        ->setTitle('PHP-GUI Dialog Input Example');

    $field->on('change', function() use ($field) {
        echo "Directory selected:\n";
        echo "\t{$field->getValue()}\n";
    });
});

$application->run();
