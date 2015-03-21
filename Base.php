<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

/**
 * The basic class of path instances
 *
 * @property-read string $type
 *                the type of the path (posix, windows, etc.)
 * @property string $path
 *           the full path
 */
abstract class Base
{
    /**
     * The constructor
     *
     * @param string $path [optional]
     *        the full path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Magic get
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        switch ($key) {
            case 'type':
                return $this->type;
            case 'path':
                return $this->path;
        }
    }

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $path;
}
