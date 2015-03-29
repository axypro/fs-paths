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
class URLTest extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $type = Paths::TYPE_URL;

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

    /**
     * @return array
     */
    public function providerGetDirName()
    {
        return [
            ['http://example.loc/folder/file.txt?x=1', 'http://example.loc/folder'],
            ['http://example.loc/folder/file.txt/?x=1', 'http://example.loc/folder/file.txt'],
            ['./../one/two?x', './../one'],
        ];
    }

    /**
     * @return array
     */
    public function providerGetFileName()
    {
        return [
            ['http://example.loc/folder/file.txt?x=1', 'file.txt'],
            ['http://example.loc/folder/file.txt/?x=1', null],
            ['./../one/two?x', 'two'],
            ['./..', '..'],
        ];
    }
}
