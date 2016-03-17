<?php

require 'vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\Edit;

$application = new Application();

$application->on('start', function() use ($application) {
    $button = new Button();
    $button->caption = 'Hey Gabi!';
    $button->left = 100;
    $button->top = 100;

    $edit = new Edit();
    $edit->text = 'Made with PHP S2!';
    $edit->left = 50;
    $edit->top = 50;
    $edit->width = 200;
});

$application->run();