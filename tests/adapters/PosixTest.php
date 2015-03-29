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
class PosixTest extends Base
{
    /**
     * {@inheritdoc}
     */
    protected $type = Paths::TYPE_POSIX;

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

    /**
     * @return array
     */
    public function providerGetDirName()
    {
        return [
            ['/var/www/robots.txt', '/var/www'],
            ['/var/www/robots.txt/', '/var/www/robots.txt'],
            ['./../file.txt', './..'],
        ];
    }

    /**
     * @return array
     */
    public function providerGetFileName()
    {
        return [
            ['/var/www/robots.txt', 'robots.txt'],
            ['/var/www/robots.txt/', null],
            ['./../file.txt', 'file.txt'],
            ['./..', '..'],
        ];
    }

    /**
     * @return array
     */
    public function providerGetBaseName()
    {
        return [
            ['/var/www/robots.txt', false, 'robots'],
            ['/var/www/robots.txt/', false, null],
            ['./../file.txt', false, 'file'],
            ['./../file.', false, 'file'],
            ['./../file', false, 'file'],
            ['./..', false, '.'],
            ['one.two.three', false, 'one.two'],
            ['one.two.three', 'three', 'one.two'],
            ['one.two.three', 'four', null],
            ['one.', null, null],
            ['one.', '', 'one'],
            ['one', null, 'one'],
            ['one', '', null],
        ];
    }
}
