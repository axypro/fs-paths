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
}
