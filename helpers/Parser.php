<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\helpers;

/**
 * Helper for parsing path
 */
class Parser
{
    /**
     * Splits a path to a directory list
     *
     * @param \axy\fs\paths\Base $path
     */
    public static function splitDirs($path)
    {
        $dirs = explode('/', $path->rel);
        if (empty($dirs)) {
            $path->dirs = [];
            return;
        }
        $file = array_pop($dirs);
        $path->dirs = $dirs;
        $path->dirName = $path->root.implode('/', $dirs);
        if ($file !== '') {
            $path->fileName = $file;
            if (preg_match('~^(.*)\.(.*)$~', $file, $matches)) {
                $path->baseName = $matches[1];
                $path->ext = $matches[2];
            } else {
                $path->baseName = $path->fileName;
            }
        }
    }
}
