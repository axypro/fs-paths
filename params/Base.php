<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\params;

/**
 * Basic class of additional parameters of a path
 */
abstract class Base
{
    /**
     * @return array
     */
    public function asArray()
    {
        return (array)$this;
    }
}
