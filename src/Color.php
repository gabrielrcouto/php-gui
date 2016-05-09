<?php

namespace Gui;

/**
 * This is the Color Class
 *
 * This class is used to manipulate color
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class Color
{
    /**
     * Convert a HTML hex color (#rrggbb) to Lazarus Color (integer)
     *
     * @param string $color
     *
     * @return int
     */
    public static function toLazarus($color)
    {
        $color = ltrim($color, '#');

        if (!ctype_xdigit($color)) {
            throw new \InvalidArgumentException('Color must be a hexdec string');
        }

        if (strlen($color) == 3) {
            list($r, $g, $b) = str_split($color, 1);

            $r = $r . $r;
            $g = $g . $g;
            $b = $b . $b;
        } elseif (strlen($color) == 6) {
            list($r, $g, $b) = str_split($color, 2);
        } else {
            throw new \InvalidArgumentException('Color must have a valid hexdec color format');
        }

        // Lazarus uses #bbggrr
        return hexdec($b . $g . $r);
    }
}
