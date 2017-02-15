<?php
/*
 * Directory Field Example
 */
require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\DirectoryField;

$application = new Application();
$application->setVerboseLevel(0);

$application->on('start', function() use ($application) {
    $field = (new DirectoryField())
        ->setLeft(10)
        ->setTop(80)
        ->setTitle('PHP-GUI Dialog Field Example');    
   
//    $field->on('EditingDone', function() use ($field){
    $field->on('change', function() use ($field){
        echo "Directory selected:\n";
        echo "\t{$field->getValue()}\n";
    });
});

//$application->on('exit', function() use($application) {
//    $application->terminate();
//    exit(0);
//});

$application->run();
