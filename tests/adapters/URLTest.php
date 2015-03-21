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
class URLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::create
     */
    public function testCreate()
    {
        $path = Paths::getAdapter(Paths::TYPE_URL)->create('http://s.loc/one');
        $this->assertInstanceOf('axy\fs\paths\URL', $path);
        $this->assertSame(Paths::TYPE_URL, $path->type);
        $this->assertSame('http://s.loc/one', $path->path);
    }
}
