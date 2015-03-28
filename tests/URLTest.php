<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests;

use axy\fs\paths\URL;
use axy\fs\paths\Paths;

/**
 * coversDefaultClass axy\fs\paths\URL
 */
class URLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     */
    public function testConstruct()
    {
        $path = new URL('http://s.loc/one');
        $this->assertSame(Paths::TYPE_URL, $path->type);
        $this->assertSame('http://s.loc/one', $path->path);
        $this->assertSame('http://s.loc/one', (string)$path);
    }

    /**
     * @dataProvider providerParse
     * @param string $sPath
     * @param array $expected
     */
    public function testParse($sPath, $expected)
    {
        $path = new URL($sPath);
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
            'full' => [
                'http://u:p@example.loc:8080/folder/file.n.txt?x=1#h1',
                [
                    'path' => 'http://u:p@example.loc:8080/folder/file.n.txt?x=1#h1',
                    'type' => 'url',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => 'http://u:p@example.loc:8080/',
                    'rel' => 'folder/file.n.txt',
                    'dirName' => 'http://u:p@example.loc:8080/folder',
                    'fileName' => 'file.n.txt',
                    'baseName' => 'file.n',
                    'ext' => 'txt',
                    'dirs' => ['folder'],
                    'params' => [
                        'scheme' => 'http',
                        'authority' => 'u:p@example.loc:8080',
                        'query' => 'x=1',
                        'fragment' => 'h1',
                    ],
                ],
            ],
            'relative' => [
                '../../x.txt?',
                [
                    'path' => '../../x.txt?',
                    'type' => 'url',
                    'subType' => null,
                    'isAbsolute' => false,
                    'root' => null,
                    'rel' => '../../x.txt',
                    'dirName' => '../..',
                    'fileName' => 'x.txt',
                    'baseName' => 'x',
                    'ext' => 'txt',
                    'dirs' => ['..', '..'],
                    'params' => [
                        'scheme' => null,
                        'authority' => null,
                        'query' => '',
                        'fragment' => null,
                    ],
                ],
            ],
            'rootSite' => [
                '/x.txt#',
                [
                    'path' => '/x.txt#',
                    'type' => 'url',
                    'subType' => null,
                    'isAbsolute' => true,
                    'root' => '/',
                    'rel' => 'x.txt',
                    'dirName' => '/',
                    'fileName' => 'x.txt',
                    'baseName' => 'x',
                    'ext' => 'txt',
                    'dirs' => [],
                    'params' => [
                        'scheme' => null,
                        'authority' => null,
                        'query' => null,
                        'fragment' => '',
                    ],
                ],
            ],
        ];
    }
}
