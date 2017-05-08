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
        ->setTop(50)
        ->setWidth(300)
        ->setTitle('PHP-GUI Dialog Input Example')
    ;

    $field->on('change', function() use ($field, $application) {
        $application->alert('Directory Chosen: ' . PHP_EOL . $field->getValue(), 'Directory Chosen');
    });
});

$application->run();
