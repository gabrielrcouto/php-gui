<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\InputText;
use Gui\Components\Label;
use Gui\Components\Shape;

$application = new Application();

$application->on('start', function() use ($application) {
    $application->alert(['Hello World!', 'WhooP!']);
});

$application->run();
