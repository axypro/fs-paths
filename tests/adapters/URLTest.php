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

    /**
     * @return array
     */
    public function providerGetBaseName()
    {
        return [
            ['http://example.loc/folder/file.txt?x=1', false, 'file'],
            ['http://example.loc/folder/file.txt?x=1', 'txt', 'file'],
            ['http://example.loc/folder/file.txt?x=1', 'html', null],
            ['http://example.loc/folder/file?x=1', null, 'file'],
            ['http://example.loc/folder/file.?x=1', null, null],
            ['http://example.loc/folder/file?x=1', '', null],
            ['http://example.loc/folder/file.?x=1', '', 'file'],
            ['http://example.loc/folder/file.p.html?x=1', false, 'file.p'],
        ];
    }

    /**
     * @return array
     */
    public function providerGetExt()
    {
        return [
            ['file:///one/file.txt', 'txt'],
            ['file:///one/file.', ''],
            ['file:///one/file', null],
            ['file:///one/file.txt.html', 'html'],
        ];
    }

    /**
     * @return array
     */
    public function providerGetDirs()
    {
        return [
            ['http://example.loc/folder/file.txt?x=1', ['folder']],
            ['http://example.loc/folder/file.txt/?x=1', ['folder', 'file.txt']],
            ['./../one/two?x', ['.', '..', 'one']],
            ['', []],
        ];
    }

    /**
     * @return array
     */
    public function providerNormalize()
    {
        return [
            ['http://example.loc:80/one/two?x=1#h1', 'http://example.loc:80/one/two?x=1#h1'],
            ['http://example.loc:80/one/two/../three/./?x=1#h1', 'http://example.loc:80/one/three/?x=1#h1'],
            ['one/../../../two', '../../two'],
        ];
    }

    /**
     * @return array
     */
    public function providerResolve()
    {
        return [
            ['/one/two/', '/three/four', '/three/four'],
            ['/one/two/', 'three/four', '/one/two/three/four'],
            ['/one/two/', '../three/four', '/one/three/four'],
            ['file:///one/two', '/three/four', 'file:///three/four'],
            ['http://a.loc:80/one/two/?x=5#h1', '/three/?y=3#h3', 'http://a.loc:80/three/?y=3#h3'],
        ];
    }
}
