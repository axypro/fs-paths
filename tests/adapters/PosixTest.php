<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests\adapters;

use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\adapters\Posix
 */
class PosixTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::create
     */
    public function testCreate()
    {
        $path = Paths::getAdapter(Paths::TYPE_POSIX)->create('/one/two');
        $this->assertInstanceOf('axy\fs\paths\Posix', $path);
        $this->assertSame(Paths::TYPE_POSIX, $path->type);
        $this->assertSame('/one/two', $path->path);
    }
}
