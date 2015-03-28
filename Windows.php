<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

/**
 * The class Windows paths
 */
class Windows extends Base
{
    /**
     * {@inheritdoc}
     */
    public $type = Paths::TYPE_WINDOWS;

    /**
     * @var string
     */
    const SUBTYPE_SERVER = 'server';
}
