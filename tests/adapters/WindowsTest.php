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
     * @var \axy\fs\paths\adapters\Windows
     */
    private $adapter;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->adapter = Paths::getAdapter(Paths::TYPE_WINDOWS);
    }

    /**
     * covers ::create
     */
    public function testCreate()
    {
        $path = $this->adapter->create('c:\one\two');
        $this->assertInstanceOf('axy\fs\paths\Windows', $path);
        $this->assertSame(Paths::TYPE_WINDOWS, $path->type);
        $this->assertSame('c:/one/two', $path->path);
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

    /**
     * @return array
     */
    public function providerIsAbsolute()
    {
        return [
            ['c:\config.sys', true],
            ['c:/config.sys', true],
            ['\\ServerName\share', true],
            ['//ServerName\share', true],
            ['/file', true],
            ['file:///file.txt', true],
            ['./../file', false],
            ['file', false],
        ];
    }
}
