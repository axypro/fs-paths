<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests;

use axy\fs\paths\Posix;
use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\Posix
 */
class PosixTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     */
    public function testConstruct()
    {
        $path = new Posix('/one/two');
        $this->assertSame(Paths::TYPE_POSIX, $path->type);
        $this->assertSame('/one/two', $path->path);
    }
}
