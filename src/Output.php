<?php

namespace Gui;

class Output
{
    protected static $out = STDOUT;
    protected static $err = STDERR;

    private static $colors = [
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'white' => 37
    ];

    public static function out($string, $color = 'white')
    {
        fwrite(
            static::$out,
            self::colorize($string . PHP_EOL, $color)
        );
    }

    public static function err($string)
    {
        fwrite(
            static::$err,
            self::colorize($string . PHP_EOL, 'red')
        );
    }

    private static function colorize($string, $color)
    {
        if (isset(self::$colors[$color])) {
            return "\033[" . self::$colors[$color] . 'm' . $string . "\033[0m";
        }

        return $string;
    }
}
