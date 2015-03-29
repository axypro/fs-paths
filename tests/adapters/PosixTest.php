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
     * @var \axy\fs\paths\adapters\Posix
     */
    private $adapter;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->adapter = Paths::getAdapter(Paths::TYPE_POSIX);
    }

    /**
     * covers ::create
     */
    public function testCreate()
    {
        $path = $this->adapter->create('/one/two');
        $this->assertInstanceOf('axy\fs\paths\Posix', $path);
        $this->assertSame(Paths::TYPE_POSIX, $path->type);
        $this->assertSame('/one/two', $path->path);
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
            ['/var/www', true],
            ['/var/www/robots.txt', true],
            ['c:/config.sys', false],
            ['file:///file.txt', false],
            ['./../file', false],
            ['file', false],
        ];
    }
}
