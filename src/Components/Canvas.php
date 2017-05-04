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
class Canvas extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string $lazarusClass
     */
    protected $lazarusClass = 'TImage';

    public function putImageData($pixels)
    {
        foreach ($pixels as $key => $value) {
            $pixels[$key] = Color::toLazarus($value);
        }

        $this->call(
            'picture.bitmap.canvas.putImageData',
            $pixels,
            $isCommand = false
        );

        return $this;
    }

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
        if (is_string($width)) {
            $parent = 0;

            if (strpos($width, "vw") !== false) {
                $width = floatval(str_replace("vw", "", $width));
                $parent = $this->getWidth();
            }
            else if (strpos($width, "vh") !== false) {
                $width = floatval(str_replace("vh", "", $width));
                $parent = $this->getheight();
            }

            $width = $parent * ($width / 100);
        }

        if (is_string($height)) {
            $parent = 0;

            if (strpos($height, "vw") !== false) {
                $height = floatval(str_replace("vw", "", $height));
                $parent = $this->getWidth();
            }
            else if (strpos($height, "vh") !== false) {
                $height = floatval(str_replace("vh", "", $height));
                $parent = $this->getheight();
            }

            $height = $parent * ($height / 100);
        }

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
