<?php

require 'vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;

$application = new Application();

$application->on('start', function() use ($application) {
    $button = new Button();
    $button->caption = 'A little button for PHP, a big button for the GUI';
});

$application->run();