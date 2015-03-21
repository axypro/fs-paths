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
}
