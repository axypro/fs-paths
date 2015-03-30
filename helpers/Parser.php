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
     * @return bool
     */
    public static function splitDirs($path)
    {
        $result = false;
        $dirs = explode('/', $path->rel);
        if (empty($dirs)) {
            $path->dirs = [];
            return;
        }
        $file = $dirs[count($dirs) - 1];
        if (in_array($file, ['.', '..'])) {
            $file = '';
            $path->rel .= '/';
            $result = true;
        } else {
            array_pop($dirs);
        }
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
        return $result;
    }
}
