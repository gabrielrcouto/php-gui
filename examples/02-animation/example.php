<?php

require __DIR__ . '/../../vendor/autoload.php';

use Gui\Application;
use Gui\Components\Label;
use Gui\Components\Shape;

$application = new Application();

$application->on('start', function() use ($application) {
    $label = (new Label())
        ->setLeft(20)
        ->setText('Click on the shape to restart the animation');

    $shape = (new Shape())
        ->setBackgroundColor('#3498db')
        ->setBorderColor('#3498db')
        ->setLeft(130);

    $animationCache = new stdClass();
    $animationCache->frame = 0;

    $shape->on('mousedown', function() use ($animationCache) {
        $animationCache->frame = 0;
    });

    /**
     * @t is the current time (or position) of the tween. This can be seconds or frames, steps,
     *seconds, ms, whatever – as long as the unit is the same as is used for the total time [3].
     * @b is the beginning value of the property.
     * @c is the change between the beginning and destination value of the property.
     * @d is the total time of the tween.
     */
    $easeOutBounce = function ($t, $b, $c, $d) {
        if (($t /= $d) < (1 / 2.75)) {
            return $c * (7.5625 * $t * $t) + $b;
        } elseif ($t < (2 / 2.75)) {
            return $c * (7.5625 * ($t -= (1.5 / 2.75)) * $t + 0.75) + $b;
        } elseif ($t < (2.5 / 2.75)) {
            return $c * (7.5625 * ($t -= (2.25 / 2.75)) * $t + 0.9375) + $b;
        } else {
            return $c * (7.5625 * ($t -= (2.625 / 2.75)) * $t + 0.984375) + $b;
        }
    };

    // Let's animate the shape!
    $application->loop->addPeriodicTimer(0.01, function() use ($shape, $animationCache, $easeOutBounce) {
        if ($animationCache->frame < 200) {
            $shape->setTop(ceil($easeOutBounce($animationCache->frame++, 0, 175, 200)));
        }
    });
});

$application->run();
