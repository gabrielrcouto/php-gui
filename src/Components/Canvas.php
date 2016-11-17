<?php

namespace Gui\Components;

use Gui\Color;
use Gui\Ipc\IpcMap;

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
     * The lazarus class as int
     *
     * @var int $lazarusClass
     */
    protected $lazarusClass = 3;

    public function putImageData($pixels)
    {
        foreach ($pixels as $key => $value) {
            $pixels[$key] = Color::toLazarus($value);
        }

        $this->call(
            IpcMap::OBJECT_METHOD_PICTURE_BITMAP_CANVAS_PUT_IMAGE_DATA,
            [
                IpcMap::PARAMS_DATA => $pixels,
            ]
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
            IpcMap::OBJECT_METHOD_PICTURE_BITMAP_CANVAS_SET_PIXEL,
            [
                IpcMap::PARAMS_DATA => $x,
                IpcMap::PARAMS_DATA1 => $y,
                IpcMap::PARAMS_DATA2 => Color::toLazarus($color)
            ]
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
            IpcMap::OBJECT_METHOD_PICTURE_BITMAP_SET_SIZE,
            [
                IpcMap::PARAMS_DATA => $width,
                IpcMap::PARAMS_DATA1 => $height
            ]
        );

        return $this;
    }
}
