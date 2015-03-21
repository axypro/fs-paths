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
        $this->assertSame('c:\one\two', $path->path);
    }
}
