<?php

namespace Gui\Components;

use Gui\Color;

/**
 * Canvas
 */
class Canvas extends Object
{
    protected $lazarusClass = 'TImage';

    public function setPixel(int $x, int $y, $color)
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

    public function setSize(int $width, int $height)
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
