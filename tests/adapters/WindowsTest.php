<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests\adapters;

use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\adapters\Windows
 */
class WindowsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::create
     */
    public function testCreate()
    {
        $path = Paths::getAdapter(Paths::TYPE_WINDOWS)->create('c:\one\two');
        $this->assertInstanceOf('axy\fs\paths\Windows', $path);
        $this->assertSame(Paths::TYPE_WINDOWS, $path->type);
        $this->assertSame('c:/one/two', $path->path);
    }
}
