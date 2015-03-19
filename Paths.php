<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\adapters\Posix;
use axy\fs\paths\adapters\Windows;
use axy\fs\paths\adapters\URL;

/**
 * Basic class and factory of implementations of path parsers
 */
class Paths
{
    /**
     * Path in a posix file system
     */
    const TYPE_POSIX = 'posix';

    /**
     * Path in a Windows file system
     */
    const TYPE_WINDOWS = 'windows';

    /**
     * URL as path
     */
    const TYPE_URL = 'url';

    /**
     * Returns an adapter for specified file system
     *
     * @param string $fs [optional]
     *        the file system (from TYPE_* const)
     *        the current system by default
     * @return \axy\fs\paths\adapters\Base
     * @throws \LogicException
     *         specified adapter is not defined
     */
    public static function getAdapter($fs = null)
    {
        if (!isset(self::$cache[$fs])) {
            switch ($fs) {
                case null:
                    $type = (DIRECTORY_SEPARATOR === '/') ? self::TYPE_POSIX : self::TYPE_WINDOWS;
                    $adapter = self::getAdapter($type);
                    break;
                case self::TYPE_POSIX:
                    $adapter = new Posix();
                    break;
                case self::TYPE_WINDOWS:
                    $adapter = new Windows();
                    break;
                case self::TYPE_URL:
                    $adapter = new Url();
                    break;
                default:
                    throw new \LogicException('Path adapter "'.$fs.'" is not defined');
            }
            self::$cache[$fs] = $adapter;
        }
        return self::$cache[$fs];
    }

    /**
     * Cache of adapters (type => implementation)
     *
     * @var \axy\fs\paths\adapters\Base[]
     */
    private static $cache = [];
}
