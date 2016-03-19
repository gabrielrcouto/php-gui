<?php
namespace Gui;

class OsDetector
{
    /**
     * @return bool
     */
    public static function isMacOS()
    {
        return false !== strpos(php_uname('s'), 'Darwin');
    }

    /**
     * @return bool
     */
    public static function isUnix()
    {
        return '/' === DIRECTORY_SEPARATOR;
    }

    /**
     * @return bool
     */
    public static function isWindows()
    {
        return '\\' === DIRECTORY_SEPARATOR;
    }
}
