<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\Paths;

/**
 * The class of POSIX paths
 */
class Posix extends Base
{
    /**
     * {@inheritdoc}
     */
    public $type = Paths::TYPE_POSIX;
}
