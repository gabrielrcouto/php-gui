<?php

/*
 * Components Gallery
 */

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Button;
use Gui\Components\Calendar;
use Gui\Components\Checkbox;
use Gui\Components\InputDate;
use Gui\Components\InputDirectory;
use Gui\Components\InputFile;
use Gui\Components\InputNumber;
use Gui\Components\InputPassword;
use Gui\Components\InputText;
use Gui\Components\InputTime;
use Gui\Components\Label;
use Gui\Components\Option;
use Gui\Components\ProgressBar;
use Gui\Components\Radio;
use Gui\Components\Select;
use Gui\Components\TextArea;

$application = new Application();

$application->on('start', function () use ($application) {
    $application->getWindow()->setTitle('PHP-GUI Components Gallery');
    $application->getWindow()->setWindowState('maximized');

    (new Button())
        ->setValue('Click')
        ->setTop(10)
        ->setLeft(10);

    (new Calendar())
        ->setTop(50)
        ->setLeft(10);

    (new Checkbox())
        ->setTop(10)
        ->setLeft(300);

    (new Label())
        ->setText('Checkbox')
        ->setTop(11)
        ->setLeft(320);

    (new Radio())
        ->setTop(30)
        ->setLeft(300)
        ->setOptions([
            new Option('Radio 1', 1),
            new Option('Radio 2', 2),
            new Option('Radio 3', 3)
        ]);

    (new InputDate())
        ->setTop(250)
        ->setLeft(10);

    (new InputDirectory())
        ->setTop(300)
        ->setLeft(10);

    (new InputFile())
        ->setTop(350)
        ->setLeft(10);

    (new InputNumber())
        ->setTop(400)
        ->setLeft(10);

    (new InputNumber(true))
        ->setTop(450)
        ->setLeft(10);

    (new InputPassword())
        ->setTop(250)
        ->setLeft(250);

    (new InputText())
        ->setTop(300)
        ->setLeft(250);

    (new InputTime())
        ->setTop(350)
        ->setLeft(250);

    (new ProgressBar())
        ->setTop(500)
        ->setLeft(10)
        ->setMin(0)
        ->setMax(100)
        ->setPosition(75);

    (new Select())
        ->setTop(10)
        ->setLeft(190)
        ->setOptions([
            new Option('Option 1', 1),
            new Option('Option 2', 2),
            new Option('Option 3', 3)
        ]);

    (new TextArea())
        ->setTop(500)
        ->setLeft(500)
        ->setValue('Text area sample');
});

$application->run();
