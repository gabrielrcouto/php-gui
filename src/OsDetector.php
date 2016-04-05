<?php

namespace Gui;

/**
 * This is the OsDetector Class
 *
 * This class is used to check to current OS
 *
 * @author Gabriel Couto @gabrielrcouto
 * @since 0.1
 */
class OsDetector
{
    /**
     * This method is used to check if the current OS is MacOs
     *
     * @return bool
     */
    public static function isMacOS()
    {
        return false !== strpos(php_uname('s'), 'Darwin');
    }

    /**
     * This method is used to check if the current OS is Unix
     *
     * @return bool
     */
    public static function isUnix()
    {
        return '/' === DIRECTORY_SEPARATOR;
    }

    /**
     * This method is used to check if the current OS is Windows
     *
     * @return bool
     */
    public static function isWindows()
    {
        return '\\' === DIRECTORY_SEPARATOR;
    }
}
