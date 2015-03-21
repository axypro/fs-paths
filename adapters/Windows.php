<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\adapters;

use axy\fs\paths\Windows as Item;

/**
 * The adapter for Windows file system
 */
class Windows extends Base
{
    /**
     * Creates a path instance
     *
     * @param string $path
     * @return \axy\fs\paths\Windows
     */
    public function create($path)
    {
        return new Item($path);
    }
}
