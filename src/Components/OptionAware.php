<?php

namespace Gui\Components;

trait OptionAware
{
    /**
     * Parse an option string received from Lazarus.
     *
     * @param string $options the options string
     * @return array
     */
    private function parseOptionString($options)
    {
        if (strlen($options) > 0) {
            return array_map('trim', explode(',', $options));
        }

        return [];
    }

    /**
     * Returns a string with the representation [option1, option2, ...] to be configured by Lazarus.
     *
     * @param array $options the options
     * @return string a string [option1, options2, option3,...]
     */
    private function getOptionString(array $options)
    {
        $str = join(', ', $options);
        return "[$str]";
    }
}
