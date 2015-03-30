<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\params\URL as URLParams;
use axy\fs\paths\helpers\Parser;

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
    public function resolve($base = null)
    {
        if ($this->isAbsolute && $base && ($this->params->scheme === null)) {
            $this->normalize();
            $base = $this->createInstance($base);
            $params = $base->params;
            $this->loadParamsResolve($params);
            if ($params->scheme !== null) {
                $prefix = $params->scheme.'://'.$params->authority;
                $this->root = $prefix.'/';
                $this->dirName = $prefix.$this->dirName;
            }
            $this->createPath();
            return $this->path;
        }
        return parent::resolve($base);
    }

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $params = new URLParams();
        $this->params = $params;
        $s = explode('://', $this->path, 2);
        if (count($s) === 2) {
            $this->isAbsolute = true;
            $params->scheme = $s[0];
            $s = explode('/', $s[1], 2);
            $params->authority = $s[0];
            $this->root = $params->scheme.'://'.$s[0].'/';
            $rel = isset($s[1]) ? $s[1] : '';
        } elseif (substr($this->path, 0, 1) === '/') {
            $this->isAbsolute = true;
            $this->root = '/';
            $rel = substr($this->path, 1);
        } else {
            $this->isAbsolute = false;
            $rel = $this->path;
        }
        $rel = explode('#', $rel, 2);
        $params->fragment = isset($rel[1]) ? $rel[1] : null;
        $rel = $rel[0];
        $rel = explode('?', $rel, 2);
        $params->query = isset($rel[1]) ? $rel[1] : null;
        $this->rel = $rel[0];
        Parser::splitDirs($this);
    }

    /**
     * {@inheritdoc}
     */
    protected function loadParamsResolve($params)
    {
        $this->params->scheme = $params->scheme;
        $this->params->authority = $params->authority;
    }

    /**
     * @return string
     */
    protected function createPath()
    {
        parent::createPath();
        $params = $this->params;
        if ($params->query !== null) {
            $this->path .= '?'.$params->query;
        }
        if ($params->fragment !== null) {
            $this->path .= '#'.$params->fragment;
        }
    }
}
