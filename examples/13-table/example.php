<?php
/*
 * Table w/ add, delete show case.
 */

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Table;
use Gui\Components\Button;

$app = new Application([
    'width'     => 430,
    'height'    => 300,
]);

$app->on('start', function () use ($app) {
    // Create table.
    $tbl = (new Table)
        ->setLeft(10)
        ->setTop(10)
        ->setWidth(300)
        ->setHeight(280)
        ->setAlternateColor('#ebebeb')
        ->setDefaultColumnWidth(100)
        ->setColumnCount(3)
        ->setRowCount(2)

        // Headers
        ->setContent(0, 0, 'ID')
        ->setContent(1, 0, 'First Name')
        ->setContent(2, 0, 'Last Name')

        // Row one.
        ->setContent(0, 1, 1)
        ->setContent(1, 1, 'Joe')
        ->setContent(2, 1, 'Bloggs');

    // Create buttons.
    $add = (new Button)
        ->setLeft(320)
        ->setTop(10)
        ->setWidth(100)
        ->setHeight(25)
        ->setValue('Add');

    $del = (new Button)
        ->setLeft(320)
        ->setTop(40)
        ->setWidth(100)
        ->setHeight(25)
        ->setValue('Delete');
    
    // Add row.
    $add->on('click', function () use ($tbl) {
        $tbl->addRow();
    });

    // Delete row.
    $del->on('click', function () use ($tbl) {
        $tbl->deleteRow();
    });
});

$app->run();
