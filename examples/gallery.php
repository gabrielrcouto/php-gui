<?php

/*
 * Components Gallery
 */
require __DIR__ . '/../vendor/autoload.php';

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

$application->on('start', function() use ($application) {
    $application->getWindow()->setTitle('PHP-GUI Components Gallery');
    $application->getWindow()->setWindowState('maximized');

    $button = (new Button())
        ->setValue('Click')
        ->setTop(10)
        ->setLeft(10);

    $calendar = (new Calendar())
        ->setTop(50)
        ->setLeft(10);

    $checkbox = (new Checkbox())
        ->setTop(10)
        ->setLeft(300);

    $label = (new Label())
        ->setText('Checkbox')
        ->setTop(11)
        ->setLeft(320);

    $radio = (new Radio())
        ->setTop(30)
        ->setLeft(300)
        ->setOptions([
            new Option('Radio 1', 1),
            new Option('Radio 2', 2),
            new Option('Radio 3', 3)
        ]);

    $date = (new InputDate())
        ->setTop(250)
        ->setLeft(10);

    $directory = (new InputDirectory())
        ->setTop(300)
        ->setLeft(10);

    $file = (new InputFile())
        ->setTop(350)
        ->setLeft(10);

    $integer= (new InputNumber())
        ->setTop(400)
        ->setLeft(10);

    $float= (new InputNumber(true))
        ->setTop(450)
        ->setLeft(10);

    $password = (new InputPassword())
        ->setTop(250)
        ->setLeft(250);

    $text = (new InputText())
        ->setTop(300)
        ->setLeft(250);

    $time = (new InputTime())
        ->setTop(350)
        ->setLeft(250);

    $progress = (new ProgressBar())
        ->setTop(500)
        ->setLeft(10)
        ->setMin(0)
        ->setMax(100)
        ->setPosition(75);

    $select = (new Select())
        ->setTop(10)
        ->setLeft(190)
        ->setOptions([
            new Option('Option 1', 1),
            new Option('Option 2', 2),
            new Option('Option 3', 3)
        ]);

    $textarea = (new TextArea())
        ->setTop(500)
        ->setLeft(500)
        ->setValue('Text area sample');
});

$application->run();
