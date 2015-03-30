<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths;

use axy\fs\paths\helpers\Resolver;

/**
 * The basic class of path instances
 *
 * @property-read string $type
 *                the type of the path (posix, windows, etc.)
 * @property string $path
 *           the full path
 */
abstract class Base
{
    /**
     * The origin path
     *
     * @var string
     */
    public $path;

    /**
     * The type of the file system
     *
     * @var string
     */
    public $type;

    /**
     * The sub type
     *
     * For example in Windows it can be "server" for path as "\\Name\folder\file.txt"
     *
     * @var string|null
     */
    public $subType;

    /**
     * The flag of absolute path (not relative)
     *
     * @var bool
     */
    public $isAbsolute;

    /**
     * The root
     *
     * "/one/two": root is "/"
     * "c:\one\two": root is "c:\"
     * "\\Name\folder\file.txt": root is "\\Name\"
     * "http://example.com/robots.txt": root is "http://example.com/"
     *
     * Root is NULL for relative paths
     *
     * @var string|null
     */
    public $root;

    /**
     * Relative path
     *
     * Relative is absolute path without root
     * For "/one/two" it is "one/two"
     *
     * @var string
     */
    public $rel;

    /**
     * The directory name (without file name)
     *
     * @var string
     */
    public $dirName;

    /**
     * The file name (without directory name)
     *
     * @var string
     */
    public $fileName;

    /**
     * The file name without the extension
     *
     * for "class.php" base name is "class"
     * for "class.inc.php" base name is "class.inc"
     *
     * @var string
     */
    public $baseName;

    /**
     * The extension of the file
     *
     * for "class.inc.php" extension is "php"
     * for "file" extension is NULL
     * for "file." extension is empty string
     *
     * @var string
     */
    public $ext;

    /**
     * The list of directories
     *
     * for "c:\one\two\file.txt" dirs is ["one", "two"]
     * for "../one/two/" dirs is ["..", "one", "two"]
     *
     * @var string[]
     */
    public $dirs;

    /**
     * The additional parameters of type (depends of file system)
     *
     * For example, for window it is name of disc or server
     * For URL it is scheme, server and GET-parameters
     *
     * @var \axy\fs\paths\params\Base
     */
    public $params;

    /**
     * The constructor
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->parse();
    }

    /**
     * Resolves and normalizes the path
     *
     * @param \axy\fs\paths\Base|string $base [optional]
     *        a base path (an instance or a string)
     * @return string
     */
    public function resolve($base = null)
    {
        $this->normalize();
        if ($this->isAbsolute || ($base === null)) {
            return $this->path;
        }
        $base = $this->createBase($base);
        $base->normalize();
        $this->root = $base->root;
        $this->isAbsolute = $base->isAbsolute;
        $this->loadDirs(Resolver::resolve($base->dirs, $this->dirs, $base->isAbsolute));
        $this->loadParamsResolve($base->params);
        $this->createPath();
        return $this->path;
    }

    /**
     * Returns the representation as an array
     *
     * @return array
     */
    public function asArray()
    {
        $result = [];
        $f = ['path', 'type', 'subType', 'isAbsolute', 'root', 'rel', 'dirName', 'fileName', 'baseName', 'ext', 'dirs'];
        foreach ($f as $k) {
            $result[$k] = $this->$k;
        }
        $result['params'] = $this->params->asArray();
        return $result;
    }

    /**
     * Parse the path
     */
    abstract protected function parse();

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->path;
    }

    public function __clone()
    {
        $this->params = clone $this->params;
    }

    /**
     * Normalizes the path
     */
    protected function normalize()
    {
        if ($this->normalized) {
            return;
        }
        $this->normalized = true;
        $dirs = $this->dirs;
        if (($this->fileName === '..') || ($this->fileName === '.')) {
            $dirs[] = $this->fileName;
            $this->fileName = null;
            $this->baseName = null;
            $this->ext = null;
        }
        $dirs = Resolver::normalize($dirs, $this->isAbsolute, $changed);
        if ($changed) {
            $this->loadDirs($dirs);
        }
    }

    /**
     * @param array $dirs
     */
    protected function loadDirs($dirs)
    {
        $this->dirs = $dirs;
        $this->dirName = (string)$this->root;
        if (!empty($dirs)) {
            $dirs = implode('/', $dirs);
            $this->rel = $dirs.'/'.$this->fileName;
            $this->dirName .= $dirs;
        } else {
            $this->rel = $this->fileName;
        }
        $this->createPath();
    }

    /**
     * @param \axy\fs\paths\params\Base $params
     */
    protected function loadParamsResolve($params)
    {
    }

    /**
     * @return string
     */
    protected function createPath()
    {
        $this->path = $this->root.$this->rel;
    }

    /**
     * @param \axy\fs\paths\Base|string $base
     * @return \axy\fs\paths\Base
     */
    protected function createBase($base)
    {
        if (!is_object($base)) {
            $className = get_class($this);
            $base = new $className($base);
        }
        return $base;
    }

    /**
     * @var bool
     */
    protected $normalized = false;
}
