<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Canvas;
use Gui\Components\Label;

$application = new Application([
    'title' => '3D Perspective',
    'left' => 248,
    'top' => 50,
    'width' => 200,
    'height' => 200
]);

$application->on('start', function () use ($application) {
    $canvasWidth = $canvasHeight = 200;

    $canvas = new Canvas([
        'top' => 0,
        'left' => 0,
        'width' => $canvasWidth,
        'height' => $canvasHeight
    ]);

    $canvas->setSize($canvasWidth, $canvasHeight);

    // based on http://thecodeplayer.com/walkthrough/3d-perspective-projection-canvas-javascript

    // pixels are 250px away from us
    $fov = 100;

    $pixels = [];

    for ($x = -250; $x < 250; $x += 5) {
        for ($z = -250; $z < 250; $z += 5) {
            $pixels[] = ['x' => $x, 'y' => 40, 'z' => $z];
        }
    }

    $lastFrame = array_fill(0, $canvasWidth * $canvasHeight, '#000000');

    $application->getLoop()
    ->addPeriodicTimer(0.03, function () use ($canvas, &$pixels, $canvasWidth, $canvasHeight, $fov, &$lastFrame) {
        $currentPixel = count($pixels);
        $newFrame = array_fill(0, $canvasWidth * $canvasHeight, '#000000');

        while ($currentPixel--) {
            $pixel = &$pixels[$currentPixel];

            //calculating 2d position for 3d coordinates
            //fov = field of view = denotes how far the pixels are from us.
            //the scale will control how the spacing between the pixels will decrease with increasing distance from us.
            $scale = $fov + $pixel['z'];

            if ($scale > 0) {
                $scale = $fov / $scale;
            }

            $x2d = $pixel['x'] * $scale + $canvasWidth / 2;
            $y2d = $pixel['y'] * $scale + $canvasHeight / 2;

            //marking the points green - only if they are inside the screen
            if ($x2d >= 0 && $x2d <= $canvasWidth && $y2d >= 0 && $y2d <= $canvasHeight) {
                //canvasWidth is multiplied with the X coordinate and then added to the Y coordinate.
                $c = (round($x2d) * $canvasWidth + round($y2d));
                $newFrame[$c] = '#00FF00';
            }

            $pixel['z'] -= 1;

            if ($pixel['z'] < -$fov) {
                $pixel['z'] += 2 * $fov;
            }
        }

        $framesDiff = array_diff_assoc($newFrame, $lastFrame);
        $lastFrame = $newFrame;

        foreach ($framesDiff as $key => $value) {
            $canvas->setPixel(floor($key / $canvasWidth), $key % $canvasWidth, $value);
        }
    });
});

$application->run();
