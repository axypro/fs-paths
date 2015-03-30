<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\adapters;

/**
 * The basic class of file system adapters
 */
abstract class Base
{
    /**
     * Creates a path instance
     *
     * @param string $path
     * @return \axy\fs\paths\Base
     */
    abstract public function create($path);

    /**
     * Checks if a path is absolute
     *
     * @param string $path
     * @return bool
     */
    public function isAbsolute($path)
    {
        return $this->create($path)->isAbsolute;
    }

    /**
     * Returns directory name of a path
     *
     * @param string $path
     * @return string
     */
    public function getDirName($path)
    {
        return $this->create($path)->dirName;
    }

    /**
     * Returns file name of a path
     *
     * @param string $path
     * @return string
     */
    public function getFileName($path)
    {
        return $this->create($path)->fileName;
    }

    /**
     * Returns file base name of a path
     *
     * @param string $path
     * @param bool $ext [optional]
     *        if the file extension is not same returns NULL
     * @return string
     */
    public function getBaseName($path, $ext = false)
    {
        $obj = $this->create($path);
        if (($ext !== false) && ($obj->ext !== $ext)) {
            return null;
        }
        return $obj->baseName;
    }

    /**
     * Returns file extension of a path
     *
     * @param string $path
     * @return string
     */
    public function getExt($path)
    {
        return $this->create($path)->ext;
    }

    /**
     * Returns directory list of a path
     *
     * @param string $path
     * @return array
     */
    public function getDirs($path)
    {
        return $this->create($path)->dirs;
    }

    /**
     * Returns subtype of a path
     *
     * @param string $path
     * @return string
     */
    public function getSubType($path)
    {
        return $this->create($path)->subType;
    }

    /**
     * Normalizes a path
     *
     * @param string $path
     * @return string
     */
    public function normalize($path)
    {
        return $this->create($path)->resolve();
    }
}
