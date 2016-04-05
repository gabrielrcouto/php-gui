<?php

namespace Gui\Components;

use Gui\Color;

/**
 * Canvas
 */
class Canvas extends Object
{
    protected $lazarusClass = 'TImage';

    public function setPixel($x, $y, $color)
    {
        $this->call(
            'picture.bitmap.canvas.setPixel',
            [
                $x,
                $y,
                Color::toLazarus($color)
            ],
            $isCommand = false
        );
    }

    public function setSize($width, $height)
    {
        $this->call(
            'picture.bitmap.setSize',
            [
                $width,
                $height
            ]
        );
    }
}
