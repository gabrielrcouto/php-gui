<?php

namespace Gui;

/**
 * This is the Output Class
 *
 * This class is used to send the output easier
 *
 * @author Rafael Reis @reisraff
 * @since 0.1
 */
class Output
{
    /**
     * The resource for out
     *
     * @var resource $out
     */
    protected static $out = STDOUT;

    /**
     * The resource for err
     *
     * @var resource $err
     */
    protected static $err = STDERR;

    /**
     * @var array $color associative array of colors
     */
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

    /**
     * This method is used to send some text to STDOUT, maybe with some color
     *
     * @param string $string the text to be sent to STDOUT
     * @param string $color the color to colorize your text
     *
     * @return void
     */
    public static function out($string, $color = 'white')
    {
        fwrite(
            static::$out,
            self::colorize($string . PHP_EOL, $color)
        );
    }

    /**
     * This method is used to send some text to STDERR
     *
     * @param string $string the text to be sent to STDERR
     *
     * @return void
     */
    public static function err($string)
    {
        fwrite(
            static::$err,
            self::colorize($string . PHP_EOL, 'red')
        );
    }

    /**
     * This method is used to colorize some text
     *
     * @param string $string the text to be colorized
     * @param string $color the color to colorize your
     *
     * @return string
     */
    private static function colorize($string, $color)
    {
        if (isset(self::$colors[$color])) {
            return "\033[" . self::$colors[$color] . 'm' . $string . "\033[0m";
        }

        return $string;
    }
}
