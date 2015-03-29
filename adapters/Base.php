<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\adapters;

/**
 * The basic class of file system adapters
 */
abstract class Base
{
    /**
     * Creates a path instance
     *
     * @param string $path
     * @return \axy\fs\paths\Base
     */
    abstract public function create($path);

    /**
     * Checks if a path is absolute
     *
     * @param string $path
     * @return bool
     */
    public function isAbsolute($path)
    {
        return $this->create($path)->isAbsolute;
    }

    /**
     * Returns directory name of a path
     *
     * @param string $path
     * @return string
     */
    public function getDirName($path)
    {
        return $this->create($path)->dirName;
    }
}
