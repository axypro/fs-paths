<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests;

use axy\fs\paths\Windows;
use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\Windows
 */
class WindowsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     */
    public function testConstruct()
    {
        $path = new Windows('c:\one\two');
        $this->assertSame(Paths::TYPE_WINDOWS, $path->type);
        $this->assertSame('c:/one/two', $path->path);
        $this->assertSame('c:/one/two', (string)$path);
    }

    /**
     * @dataProvider providerParse
     * @param string $sPath
     * @param array $expected
     */
    public function testParse($sPath, $expected)
    {
        $path = new Windows($sPath);
        $actual = $path->asArray();
        foreach ($expected as $k => $v) {
            $this->assertSame($expected[$k], $actual[$k], $k);
        }
    }

    /**
     * @return array
     */
    public function providerParse()
    {
        return [
            'absolute' => [
                'c:\one\two\file.n.txt',
                [
                    'path' => 'c:/one/two/file.n.txt',
                    'type' => 'windows',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => 'c:/',
                    'rel' => 'one/two/file.n.txt',
                    'dirName' => 'c:/one/two',
                    'fileName' => 'file.n.txt',
                    'baseName' => 'file.n',
                    'ext' => 'txt',
                    'dirs' => ['one', 'two'],
                    'params' => [
                        'disc' => 'c',
                        'server' => null,
                    ],
                ],
            ],
            'ext' => [
                'c:\one/two\file.n.txt.',
                [
                    'path' => 'c:/one/two/file.n.txt.',
                    'type' => 'windows',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => 'c:/',
                    'rel' => 'one/two/file.n.txt.',
                    'dirName' => 'c:/one/two',
                    'fileName' => 'file.n.txt.',
                    'baseName' => 'file.n.txt',
                    'ext' => '',
                    'dirs' => ['one', 'two'],
                    'params' => [
                        'disc' => 'c',
                        'server' => null,
                    ],
                ],
            ],
            'emptyDisc' => [
                '\one\two\file',
                [
                    'path' => '/one/two/file',
                    'type' => 'windows',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => '/',
                    'rel' => 'one/two/file',
                    'dirName' => '/one/two',
                    'fileName' => 'file',
                    'baseName' => 'file',
                    'ext' => null,
                    'dirs' => ['one', 'two'],
                    'params' => [
                        'disc' => '',
                        'server' => null,
                    ],
                ],
            ],
            'dir' => [
                'c:\one\two\file.n.txt\\',
                [
                    'path' => 'c:/one/two/file.n.txt/',
                    'type' => 'windows',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => 'c:/',
                    'rel' => 'one/two/file.n.txt/',
                    'dirName' => 'c:/one/two/file.n.txt',
                    'fileName' => null,
                    'baseName' => null,
                    'ext' => null,
                    'dirs' => ['one', 'two', 'file.n.txt'],
                    'params' => [
                        'disc' => 'c',
                        'server' => null,
                    ],
                ],
            ],
            'server' => [
                '\\\\ServerName\share\folder\file.txt',
                [
                    'path' => '//ServerName/share/folder/file.txt',
                    'type' => 'windows',
                    'subType' => 'server',
                    'isAbsolute' => true,
                    'root' => '//ServerName/',
                    'rel' => 'share/folder/file.txt',
                    'dirName' => '//ServerName/share/folder',
                    'fileName' => 'file.txt',
                    'baseName' => 'file',
                    'ext' => 'txt',
                    'dirs' => ['share', 'folder'],
                    'params' => [
                        'disc' => null,
                        'server' => 'ServerName',
                    ],
                ],
            ],
            'relative' => [
                'one\..\two',
                [
                    'path' => 'one/../two',
                    'type' => 'windows',
                    'subType' => null,
                    'isAbsolute' => false,
                    'root' => null,
                    'rel' => 'one/../two',
                    'dirName' => 'one/..',
                    'fileName' => 'two',
                    'baseName' => 'two',
                    'ext' => null,
                    'dirs' => ['one', '..'],
                    'params' => [
                        'disc' => null,
                        'server' => null,
                    ],
                ],
            ],
            'url' => [
                'file:///file.txt',
                [
                    'path' => 'file:///file.txt',
                    'type' => 'windows',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => 'file:/',
                    'rel' => '//file.txt',
                    'dirName' => 'file://',
                    'fileName' => 'file.txt',
                    'baseName' => 'file',
                    'ext' => 'txt',
                    'dirs' => ['', ''],
                    'params' => [
                        'disc' => 'file',
                        'server' => null,
                    ],
                ],
            ],
        ];
    }
}
