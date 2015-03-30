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

    /**
     * covers ::create
     */
    public function testCreate()
    {
        $posix = Paths::create('/one/two', 'posix');
        $this->assertInstanceOf('axy\fs\paths\Posix', $posix);
        $this->assertSame(Paths::TYPE_POSIX, $posix->type);
        $this->assertSame('/one/two', $posix->path);
        $windows = Paths::create('c:/autoexec.bat', 'windows');
        $this->assertInstanceOf('axy\fs\paths\Windows', $windows);
        $this->assertSame(Paths::TYPE_WINDOWS, $windows->type);
        $this->assertSame('c:/autoexec.bat', $windows->path);
        $url = Paths::create('file:///x.txt', 'url');
        $this->assertInstanceOf('axy\fs\paths\URL', $url);
        $this->assertSame(Paths::TYPE_URL, $url->type);
        $this->assertSame('file:///x.txt', $url->path);
        $current = Paths::create('./../');
        if (DIRECTORY_SEPARATOR === '/') {
            $this->assertInstanceOf('axy\fs\paths\Posix', $current);
            $this->assertSame(Paths::TYPE_POSIX, $current->type);
        } else {
            $this->assertInstanceOf('axy\fs\paths\Windows', $current);
            $this->assertSame(Paths::TYPE_WINDOWS, $current->type);
        }
        $this->assertSame('./../', $current->path);
        $this->setExpectedException('LogicException');
        Paths::create('./../', 'ZX');
    }

    /**
     * covers ::isAbsolute
     * covers ::getDirName
     * covers ::getFileName
     * covers ::getBaseName
     * covers ::getExt
     * covers ::getDirs
     * covers ::getSubType
     */
    public function testMethods()
    {
        $this->assertTrue(Paths::isAbsolute('/file'));
        $this->assertFalse(Paths::isAbsolute('file'));
        $this->assertSame('./../dir', Paths::getDirName('./../dir/file.txt'));
        $this->assertSame('file.txt', Paths::getFileName('./../dir/file.txt'));
        $this->assertSame('file', Paths::getBaseName('./../dir/file.txt'));
        $this->assertSame('file', Paths::getBaseName('./../dir/file.txt', 'txt'));
        $this->assertSame('txt', Paths::getExt('./../dir/file.txt'));
        $this->assertNull(Paths::getBaseName('./../dir/file.txt', 'html'));
        $this->assertSame(['.', '..', 'dir'], Paths::getDirs('./../dir/file.txt'));
        $this->assertNull(Paths::getSubType('file.txt'));
    }

    /**
     * covers ::normalize
     */
    public function testNormalize()
    {
        $this->assertSame('one/three/four', Paths::normalize('one/two/../three/./four'));
    }

    /**
     * covers ::resolve
     */
    public function testResolve()
    {
        $this->assertSame('one/three', Paths::resolve('one/two/', '../three'));
    }
}
