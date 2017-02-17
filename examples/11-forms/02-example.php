<?php

/*
 * File Field Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\OpenOptions;
use Gui\Components\FileField;

$application = new Application();
$application->setVerboseLevel(0);

$application->on('start', function() use ($application) {
    $field = (new FileField())
            ->setLeft(10)
            ->setTop(80)
            ->setAutoSize(true)
            ->setBaseDir('C:\Users\Arthur\Documents\NetBeansProjects\php-gui')
            ->setDialogOptions(OpenOptions::ALLOW_MULTI_SELECT)
//            ->setDialogOptions(OpenOptions::ALLOW_MULTI_SELECT, OpenOptions::OLD_STYLE_DIALOG)
//            ->setExtensionFilter([
//                'xml' => 'XML File',
//                'json' => 'JSON File'
//            ])
//            ->setHideDirectory(true)
//            ->setButtonOnlyWhenFocused(true)
//            ->setAutoSelect(true)
            ;

//    var_dump($field->isHidedirectory());

    $field->on('change', function() use ($field) {
        echo $field->getFileList();
//        echo "File selected:\n";
//        echo "\t{$field->getValue()}\n";
    });
});

$application->run();
