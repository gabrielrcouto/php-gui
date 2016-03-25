<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\InputText;

$application = new Application();

$application->on('start', function() use ($application) {
    $button = new Button();
    $button->counter = 1;
    $button->left    = 100;
    $button->top     = 100;
    $button->value = 'Dont click';

    $input = new InputText();
    $input->left  = 50;
    $input->text  = 'Made with PHP S2!';
    $input->top   = 50;
    $input->width = 200;

    $button->on('click', function() use ($button, $input) {
        $button->value = 'Ouch ' . $button->counter++ . 'x';

        if ($button->counter == 20) {
            $input->text = 'Please, stop!';
        } else if ($button->counter == 30) {
            $button->visible = false;
        }
    });
});

$application->run();