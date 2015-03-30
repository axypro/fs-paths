<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\adapters\Posix as PosixAdapter;
use axy\fs\paths\adapters\Windows as WindowsAdapter;
use axy\fs\paths\adapters\URL as URLAdapter;

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
     *         specified file system is not defined
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
                    $adapter = new PosixAdapter();
                    break;
                case self::TYPE_WINDOWS:
                    $adapter = new WindowsAdapter();
                    break;
                case self::TYPE_URL:
                    $adapter = new UrlAdapter();
                    break;
                default:
                    throw new \LogicException('Path adapter "'.$fs.'" is not defined');
            }
            self::$cache[$fs] = $adapter;
        }
        return self::$cache[$fs];
    }

    /**
     * Creates a path instance
     *
     * @param string $path
     *        the path string
     * @param string $fs [optional]
     *        the file system (from TYPE_* const)
     *        the current system by default
     * @return \axy\fs\paths\Base
     * @throws \LogicException
     *         specified file system is not defined
     */
    public static function create($path, $fs = null)
    {
        return self::getAdapter($fs)->create($path);
    }

    /**
     * Checks if a path is absolute
     *
     * @param string $path
     * @return bool
     */
    public static function isAbsolute($path)
    {
        return self::getAdapter()->isAbsolute($path);
    }

    /**
     * Returns directory name of a path
     *
     * @param string $path
     * @return string
     */
    public static function getDirName($path)
    {
        return self::getAdapter()->getDirName($path);
    }

    /**
     * Returns file name of a path
     *
     * @param string $path
     * @return string
     */
    public static function getFileName($path)
    {
        return self::getAdapter()->getFileName($path);
    }

    /**
     * Returns file base name of a path
     *
     * @param string $path
     * @param bool $ext [optional]
     *        if the file extension is not same returns NULL
     * @return string
     */
    public static function getBaseName($path, $ext = false)
    {
        return self::getAdapter()->getBaseName($path, $ext);
    }

    /**
     * Returns file extension of a path
     *
     * @param string $path
     * @return string
     */
    public static function getExt($path)
    {
        return self::getAdapter()->getExt($path);
    }

    /**
     * Returns directory list of a path
     *
     * @param string $path
     * @return array
     */
    public static function getDirs($path)
    {
        return self::getAdapter()->getDirs($path);
    }

    /**
     * Returns subtype of a path
     *
     * @param string $path
     * @return string
     */
    public static function getSubType($path)
    {
        return self::getAdapter()->getSubType($path);
    }

    /**
     * Normalizes a path
     *
     * @param string $path
     * @return string
     */
    public static function normalize($path)
    {
        return self::getAdapter()->normalize($path);
    }

    /**
     * Cache of adapters (type => implementation)
     *
     * @var \axy\fs\paths\adapters\Base[]
     */
    private static $cache = [];
}
