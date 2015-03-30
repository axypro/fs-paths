<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests\adapters;

use axy\fs\paths\Paths;

abstract class Base extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \axy\fs\paths\adapters\Base
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $type;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->adapter = Paths::getAdapter($this->type);
    }

    /**
     * covers ::isAbsolute
     * @dataProvider providerIsAbsolute
     * @param string $path
     * @param bool $expected
     */
    public function testIsAbsolute($path, $expected)
    {
        $this->assertSame($expected, $this->adapter->isAbsolute($path));
    }

    abstract public function providerIsAbsolute();

    /**
     * covers ::getDirName
     * @dataProvider providerGetDirName
     * @param string $path
     * @param bool $expected
     */
    public function testGetDirName($path, $expected)
    {
        $this->assertSame($expected, $this->adapter->getDirName($path));
    }

    abstract public function providerGetDirName();

    /**
     * covers ::getFileName
     * @dataProvider providerGetFileName
     * @param string $path
     * @param bool $expected
     */
    public function testGetFileName($path, $expected)
    {
        $this->assertSame($expected, $this->adapter->getFileName($path));
    }

    abstract public function providerGetFileName();

    /**
     * covers ::getFileName
     * @dataProvider providerGetBaseName
     * @param string $path
     * @param string $ext
     * @param bool $expected
     */
    public function testGetBaseName($path, $ext, $expected)
    {
        $this->assertSame($expected, $this->adapter->getBaseName($path, $ext));
    }

    abstract public function providerGetBaseName();

    /**
     * covers ::getExt
     * @dataProvider providerGetExt
     * @param string $path
     * @param bool $expected
     */
    public function testGetExt($path, $expected)
    {
        $this->assertSame($expected, $this->adapter->getExt($path));
    }

    abstract public function providerGetExt();

    /**
     * covers ::getDirs
     * @dataProvider providerGetDirs
     * @param string $path
     * @param bool $expected
     */
    public function testGetDirs($path, $expected)
    {
        $this->assertSame($expected, $this->adapter->getDirs($path));
    }

    abstract public function providerGetDirs();

    /**
     * covers ::normalize
     * @dataProvider providerNormalize
     * @param string $path
     * @param bool $expected
     */
    public function testNormalize($path, $expected)
    {
        $this->assertSame($expected, $this->adapter->normalize($path));
    }

    abstract public function providerNormalize();
}
