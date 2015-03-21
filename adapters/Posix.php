<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\adapters;

use axy\fs\paths\Posix as Item;

/**
 * The adapter for POSIX file system
 */
class Posix extends Base
{
    /**
     * Creates a path instance
     *
     * @param string $path
     * @return \axy\fs\paths\Posix
     */
    public function create($path)
    {
        return new Item($path);
    }
}
