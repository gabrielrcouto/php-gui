<?php
namespace Gui;

class Color
{
    /**
     * Convert a HTML hex color (#rrggbb) to Lazarus Color (integer)
     * @return int
     */
    public static function toLazarus($color)
    {
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 3) {
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        }

        // Lazarus uses #bbggrr
        return hexdec($color[4] . $color[5] . $color[2] . $color[3] . $color[0] . $color[1]);
    }
}
