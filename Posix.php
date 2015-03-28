<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\params\Posix as PosixParams;
use axy\fs\paths\helpers\Parser;

/**
 * The class of POSIX paths
 */
class Posix extends Base
{
    /**
     * {@inheritdoc}
     */
    public $type = Paths::TYPE_POSIX;

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $path = $this->path;
        $this->params = new PosixParams();
        if (substr($path, 0, 1) === '/') {
            $this->isAbsolute = true;
            $this->root = '/';
            $this->rel = substr($path, 1);
        } else {
            $this->isAbsolute = false;
            $this->rel = $path;
        }
        Parser::splitDirs($this);
    }
}
