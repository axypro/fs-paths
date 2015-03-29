<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests\adapters;

use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\adapters\URL
 */
class URLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \axy\fs\paths\adapters\URL
     */
    private $adapter;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->adapter = Paths::getAdapter(Paths::TYPE_URL);
    }

    /**
     * covers ::create
     */
    public function testCreate()
    {
        $path = $this->adapter->create('http://s.loc/one');
        $this->assertInstanceOf('axy\fs\paths\URL', $path);
        $this->assertSame(Paths::TYPE_URL, $path->type);
        $this->assertSame('http://s.loc/one', $path->path);
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
            ['http://example.loc/folder/file.html?x=1', true],
            ['/folder/file.html?x=1', true],
            ['file:///file', true],
            ['c:\file', false],
            ['./../file', false],
        ];
    }
}
