<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

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
}
