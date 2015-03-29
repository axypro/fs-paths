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
            ['.\..', '..'],
        ];
    }
}
