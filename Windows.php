<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\params\Windows as WindowsParams;
use axy\fs\paths\helpers\Parser;

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

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $path = str_replace('\\', '/', $this->path);
        $this->path = $path;
        $this->params = new WindowsParams();
        if (preg_match('~^//([^/]+)/(.*)$~s', $path, $matches)) {
            $this->subType = self::SUBTYPE_SERVER;
            $this->root = '//'.$matches[1].'/';
            $this->params->server = $matches[1];
            $this->rel = $matches[2];
            $this->isAbsolute = true;
        } elseif (preg_match('~^(([a-z]+):)?/(.*)$~si', $path, $matches)) {
            $this->root = $matches[1].'/';
            $this->params->disc = $matches[2];
            $this->rel = $matches[3];
            $this->isAbsolute = true;
        } else {
            $this->isAbsolute = false;
            $this->rel = $path;
        }
        Parser::splitDirs($this);
    }
}
