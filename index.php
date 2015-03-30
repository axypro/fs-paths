<?php
/**
 * Manipulation of the file system paths
 *
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 * @license https://raw.github.com/axypro/fs-paths/master/LICENSE MIT
 * @link https://github.com/axypro/fs-paths repository
 * @link https://github.com/axypro/fs-paths/blob/master/README.md documentation
 * @uses PHP5.4+
 */

namespace axy\fs\paths;

if (!is_file(__DIR__.'/vendor/autoload.php')) {
    throw new \LogicException('Please: composer install');
}

require_once(__DIR__.'/vendor/autoload.php');
