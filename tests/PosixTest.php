<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests;

use axy\fs\paths\Posix;
use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\Posix
 */
class PosixTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     */
    public function testConstruct()
    {
        $path = new Posix('/one/two');
        $this->assertSame(Paths::TYPE_POSIX, $path->type);
        $this->assertSame('/one/two', $path->path);
        $this->assertSame('/one/two', (string)$path);
    }

    /**
     * @dataProvider providerParse
     * @param string $sPath
     * @param array $expected
     */
    public function testParse($sPath, $expected)
    {
        $path = new Posix($sPath);
        $this->assertEquals($expected, $path->asArray());
    }

    /**
     * @return array
     */
    public function providerParse()
    {
        return [
            'absolute' => [
                '/one/two/three/file.n.txt',
                [
                    'path' => '/one/two/three/file.n.txt',
                    'type' => 'posix',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => '/',
                    'rel' => 'one/two/three/file.n.txt',
                    'dirName' => '/one/two/three',
                    'fileName' => 'file.n.txt',
                    'baseName' => 'file.n',
                    'ext' => 'txt',
                    'dirs' => ['one', 'two', 'three'],
                    'params' => [],
                ],
            ],
            'relative' => [
                './../one/two',
                [
                    'path' => './../one/two',
                    'type' => 'posix',
                    'subType' => null,
                    'isAbsolute' => false,
                    'root' => null,
                    'rel' => './../one/two',
                    'dirName' => './../one',
                    'fileName' => 'two',
                    'baseName' => 'two',
                    'ext' => null,
                    'dirs' => ['.', '..', 'one'],
                    'params' => [],
                ],
            ],
            'ext' => [
                './../one/two.',
                [
                    'path' => './../one/two.',
                    'type' => 'posix',
                    'subType' => null,
                    'isAbsolute' => false,
                    'root' => null,
                    'rel' => './../one/two.',
                    'dirName' => './../one',
                    'fileName' => 'two.',
                    'baseName' => 'two',
                    'ext' => '',
                    'dirs' => ['.', '..', 'one'],
                    'params' => [],
                ],
            ],
            'dir' => [
                '/one/two/three/file.n.txt/',
                [
                    'path' => '/one/two/three/file.n.txt/',
                    'type' => 'posix',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => '/',
                    'rel' => 'one/two/three/file.n.txt/',
                    'dirName' => '/one/two/three/file.n.txt',
                    'fileName' => null,
                    'baseName' => null,
                    'ext' => null,
                    'dirs' => ['one', 'two', 'three', 'file.n.txt'],
                    'params' => [],
                ],
            ],
        ];
    }
}
