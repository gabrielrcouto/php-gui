<?php

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Image;

$app = new Application([
    'title' => 'My PHP Desktop Application',
    'width' => 506,
    'height' => 170,
    'icon' => realpath(__DIR__) . DIRECTORY_SEPARATOR . 'php.ico'
]);

$app->on('start', function () use ($app) {
    $file = sprintf('%s/php-gui-logo.png', dirname(__FILE__));
    $imgw = 506;
    $imgh = 170;

    $image = new Image([]);

    $image->setFile($file);
});

$app->run();
