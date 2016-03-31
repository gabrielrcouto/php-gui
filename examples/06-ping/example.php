<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Output;

$application = new Application([
    'title' => 'My PHP Desktop Application',
    'left' => 248,
    'top' => 50,
    'width' => 400,
    'height' => 200
]);

$application->on('start', function() use ($application) {
    $label = new Label([
        'text' => 'Time: ',
        'fontSize' => 20,
        'top' => 10,
        'left' => 10,
    ]);

    while (true) {
        $time = $application->ping();

        $label->setText('Time: ' . $time);

        Output::out($time, 'yellow');
        usleep(1);
    }
});

$application->run();
