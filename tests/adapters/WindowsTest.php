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
class WindowsTest extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $type = Paths::TYPE_WINDOWS;
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

    /**
     * @return array
     */
    public function providerGetDirName()
    {
        return [
            ['c:\one\two\three', 'c:/one/two'],
            ['c:\one\two\three\\', 'c:/one/two/three'],
            ['.\..\file.txt', './..'],
        ];
    }

    /**
     * @return array
     */
    public function providerGetFileName()
    {
        return [
            ['c:\one\two\three', 'three'],
            ['c:\one\two\three\\', null],
            ['.\..\file.txt', 'file.txt'],
            ['.\..', null],
        ];
    }

    /**
     * @return array
     */
    public function providerGetBaseName()
    {
        return [
            ['c:\www\robots.txt', false, 'robots'],
            ['c:\www\robots.txt\\', false, null],
            ['.\..\file.txt', false, 'file'],
            ['.\..\file.', false, 'file'],
            ['.\..\file', false, 'file'],
            ['.\..', false, null],
            ['one.two.three', false, 'one.two'],
            ['one.two.three', 'three', 'one.two'],
            ['one.two.three', 'four', null],
            ['one.', null, null],
            ['one.', '', 'one'],
            ['one', null, 'one'],
            ['one', '', null],
        ];
    }

    /**
     * @return array
     */
    public function providerGetExt()
    {
        return [
            ['c:\one/file.txt', 'txt'],
            ['c:\one/file.', ''],
            ['c:\one/file', null],
            ['c:\one/file.txt.html', 'html'],
        ];
    }

    /**
     * @return array
     */
    public function providerGetDirs()
    {
        return [
            ['c:\one\two\three', ['one', 'two']],
            ['\\\\ServerName\one\two\three\\', ['one', 'two', 'three']],
            ['c:\one', []],
            ['.\..\one\two', ['.', '..', 'one']],
        ];
    }

    /**
     * covers ::getSubType
     */
    public function testGetSubType()
    {
        $this->assertNull($this->adapter->getSubType('c:\dir\file.ext'));
        $this->assertNull($this->adapter->getSubType('\dir\file.ext'));
        $this->assertNull($this->adapter->getSubType('.\..\dir\file.ext'));
        $this->assertSame('server', $this->adapter->getSubType('\\\\ServerName\share\file'));
    }

    /**
     * @return array
     */
    public function providerNormalize()
    {
        return [
            ['c:\one\two', 'c:/one/two'],
            ['\one\two\..\three\.\four\\', '/one/three/four/'],
            ['\\\\Server\one\..\..\..\two', '//Server/two'],
            ['one\..\..\..\two', '../../two'],
        ];
    }

    /**
     * @return array
     */
    public function providerResolve()
    {
        return [
            ['c:\one\two\\', 'c:\three\four', 'c:/three/four'],
            ['c:\one\two\\', 'three\four\\', 'c:/one/two/three/four/'],
        ];
    }
}
