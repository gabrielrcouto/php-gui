<?php

namespace Gui;

/**
 * This is the Options Matriz Manager Class
 *
 * It is a manager for matrix of the options
 *
 * @author Everton da Rosa @everton3x
 * @since 0.1
 */
class OptionMgr
{
    /**
     * Returns a string with the representation [option1, option2, ...] to be configured by Lazarus.
     *
     * @param array $options the options
     * @return string a string [option1, options2, option3,...]
     */
    public static function getOptionString($options)
    {
        $str = join(', ', $options);
        return "[$str]";
    }

    /**
     * Parse an option string received from Lazarus.
     *
     * @param string $options the options string
     * @return array
     */
    public static function parseOptionString($options)
    {
        if(strlen($options) > 0){
            return array_map('trim', explode(',', $options));
        }else{
            return [];
        }
    }
}