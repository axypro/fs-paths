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
}
