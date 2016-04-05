<?php

namespace Gui\Components;

use Gui\Color;

/**
 * This is the Canvas Class
 *
 * It is a visual component for canvas
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Canvas extends Object
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TImage';

    /**
     * Sets the pixel color
     *
     * @param int $x
     * @param int $x
     * @param string $color
     *
     * @return self
     */
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

        return $this;
    }

    /**
     * Sets the canvas size
     *
     * @param int $width
     * @param int $height
     *
     * @return self
     */
    public function setSize($width, $height)
    {
        $this->call(
            'picture.bitmap.setSize',
            [
                $width,
                $height
            ]
        );

        return $this;
    }
}
