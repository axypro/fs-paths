<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\params\URL as URLParams;

/**
 * The class of URL
 */
class URL extends Base
{
    /**
     * {@inheritdoc}
     */
    public $type = Paths::TYPE_URL;

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $this->params = new URLParams();
    }
}
