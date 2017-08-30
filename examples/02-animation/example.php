<?php

// Normal autoload
$autoload = __DIR__ . '/../../vendor/autoload.php';

// support for composer require autoload
if (! file_exists($autoload)) {
    $autoload = __DIR__ . '/../../../../autoload.php';
}

require $autoload;

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\Shape;

$application = new Application();

$application->on('start', function () use ($application) {
    (new Label())
        ->setLeft(20)
        ->setText('Click on the shape to restart the animation');

    $shape = (new Shape())
        ->setBackgroundColor('#3498db')
        ->setBorderColor('#3498db')
        ->setLeft(130);

    $animationCache = new stdClass();
    $animationCache->frame = 0;

    $shape->on('mousedown', function () use ($animationCache) {
        $animationCache->frame = 0;
    });

    /**
     * @param $t int|float is the current time (or position) of the tween. This can be seconds or frames, steps,
     *           seconds, ms, whatever – as long as the unit is the same as is used for the total time [3].
     * @param $b int|float is the beginning value of the property.
     * @param $c int|float is the change between the beginning and destination value of the property.
     * @param $d int|float is the total time of the tween.
     *
     * @return float|int
     */
    $easeOutBounce = function ($t, $b, $c, $d) {
        if (($t /= $d) < (1 / 2.75)) {
            return $c * (7.5625 * $t * $t) + $b;
        }

        if ($t < (2 / 2.75)) {
            return $c * (7.5625 * ($t -= (1.5 / 2.75)) * $t + 0.75) + $b;
        }

        if ($t < (2.5 / 2.75)) {
            return $c * (7.5625 * ($t -= (2.25 / 2.75)) * $t + 0.9375) + $b;
        }

        return $c * (7.5625 * ($t -= (2.625 / 2.75)) * $t + 0.984375) + $b;
    };

    // Let's animate the shape!
    $application->getLoop()->addPeriodicTimer(0.01, function () use ($shape, $animationCache, $easeOutBounce) {
        if ($animationCache->frame < 200) {
            $shape->setTop(ceil($easeOutBounce($animationCache->frame++, 0, 175, 200)));
        }
    });
});

$application->run();
