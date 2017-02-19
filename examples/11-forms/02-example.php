<?php

/*
 * File Field Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\OpenOptions;
use Gui\Components\InputFile;

$application = new Application();

$application->on('start', function() use ($application) {
    $field = (new InputFile())
            ->setLeft(10)
            ->setTop(80)
            ->setWidth(200)
            ->setAutoSize(true)
            ->setBaseDir('C:\Users\Arthur\Documents\NetBeansProjects\php-gui')
            ->setDialogOptions(OpenOptions::ALLOW_MULTI_SELECT)
            ;

    $field->on('change', function() use ($application, $field) {
        $application->alert(implode(', ', $field->getValue()), 'Files');
    });
});

$application->run();
