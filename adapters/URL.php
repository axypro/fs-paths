<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\adapters;

use axy\fs\paths\URL as Item;

/**
 * The adapter for URL
 */
class URL extends Base
{
    /**
     * Creates a path instance
     *
     * @param string $path
     * @return \axy\fs\paths\URL
     */
    public function create($path)
    {
        return new Item($path);
    }
}
