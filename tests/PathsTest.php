<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests;

use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\Paths
 */
class PathsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::getAdapter
     */
    public function testGetAdapter()
    {
        $posix = Paths::getAdapter(Paths::TYPE_POSIX);
        $this->assertInstanceOf('axy\fs\paths\adapters\Posix', $posix);
        $windows = Paths::getAdapter(Paths::TYPE_WINDOWS);
        $this->assertInstanceOf('axy\fs\paths\adapters\Windows', $windows);
        $url = Paths::getAdapter(Paths::TYPE_URL);
        $this->assertInstanceOf('axy\fs\paths\adapters\URL', $url);
        $this->assertSame($posix, Paths::getAdapter('posix'));
        $this->assertSame($windows, Paths::getAdapter('windows'));
        $this->assertSame($url, Paths::getAdapter('url'));
        $current = Paths::getAdapter();
        $this->assertSame($current, Paths::getAdapter());
        if (DIRECTORY_SEPARATOR === '/') {
            $this->assertSame($posix, $current);
        } else {
            $this->assertSame($windows, $current);
        }
        $this->setExpectedException('LogicException');
        Paths::getAdapter('DOS');
    }
}
