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
        $actual = $path->asArray();
        foreach ($expected as $k => $v) {
            $this->assertSame($v, $actual[$k], $k);
        }
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

    /**
     * covers ::resolve
     * @dataProvider providerResolve
     * @param string $path
     * @param string $base
     * @param string $expected
     */
    public function testResolve($path, $base, $expected)
    {
        $p1 = new Posix($path);
        $this->assertSame($expected, $p1->resolve($base));
        $test = new Posix($expected);
        $this->assertSame($test->asArray(), $p1->asArray());
        if ($base !== null) {
            $base = new Posix($base);
            $p2 = new Posix($path);
            $this->assertSame($expected, $p2->resolve($base));
            $this->assertSame($test->asArray(), $p2->asArray());
        }
    }

    /**
     * @return array
     */
    public function providerResolve()
    {
        return [
            'ok' => [
                '/one/two/three',
                null,
                '/one/two/three',
            ],
            'normalize' => [
                '/one/two/../four/./five',
                null,
                '/one/four/five',
            ],
            'root' => [
                '/one/../../../two',
                null,
                '/two',
            ],
            'rootR' => [
                'one/../two',
                null,
                'two',
            ],
            'absolute' => [
                '/one/two',
                '/base/path',
                '/one/two',
            ],
            'relative' => [
                'one/two',
                '/base/path/',
                '/base/path/one/two',
            ],
            'relativeF' => [
                'one/two',
                '/base/path',
                '/base/one/two',
            ],
            'up' => [
                './../file',
                'one/two/three',
                'one/file',
            ],
            'upDir' => [
                './../file',
                'one/two/three/',
                'one/two/file',
            ],
            'up2' => [
                './../../../../file',
                'one/two/three',
                '../../file',
            ],
            'up3' => [
                './../../../../file',
                '/one/two/three',
                '/file',
            ],
            'last' => [
                '/one/two/three/..',
                null,
                '/one/two/',
            ],
            'last2' => [
                '/one/two/three/.',
                null,
                '/one/two/three/',
            ],
            'baseNorm' => [
                './../file',
                '/one/two/../three/four/file.txt',
                '/one/three/file',
            ],
        ];
    }

    public function testClone()
    {
        $path = new Posix('/one/two');
        $pathC = clone $path;
        $this->assertEquals($path->asArray(), $pathC->asArray());
        $this->assertNotSame($path->params, $pathC->params);
        $this->assertInstanceOf('axy\fs\paths\params\Posix', $pathC->params);
    }
}
