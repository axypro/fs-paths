<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\tests;

use axy\fs\paths\helpers\Resolver;

/**
 * coversDefaultClass axy\fs\paths\helpers\Resolver
 */
class ResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::normalize
     * @dataProvider providerNormalize
     * @param array $components
     * @param bool $absolute
     * @param array $expected
     * @param bool $changed
     */
    public function testNormalize($components, $absolute, $expected, $changed)
    {
        $this->assertSame($expected, Resolver::normalize($components, $absolute, $ch));
        $this->assertSame($changed, $ch);
    }

    /**
     * @return array
     */
    public function providerNormalize()
    {
        return [
            [
                [],
                true,
                [],
                false,
            ],
            [
                ['one', 'two'],
                true,
                ['one', 'two'],
                false,
            ],
            [
                ['one', 'two', '.'],
                true,
                ['one', 'two'],
                true,
            ],
            [
                ['one', 'two', 'three', '..', 'four', '.', 'five'],
                true,
                ['one', 'two', 'four', 'five'],
                true,
            ],
            [
                ['one', 'two', '..', 'three', '..', '..', '..', '..', 'four', 'five', '..', 'six'],
                true,
                ['four', 'six'],
                true,
            ],
            [
                ['one', 'two', '..', 'three', '..', '..', '..', '..', 'four', 'five', '..', 'six'],
                false,
                ['..', '..', 'four', 'six'],
                true,
            ],
            [
                ['one', '..', '..', '..', 'three', '..', '..', '..', 'four', 'five', '.'],
                false,
                ['..', '..', '..', '..', 'four', 'five'],
                true,
            ],
        ];
    }

    /**
     * covers ::resolve
     * @dataProvider providerResolve
     * @param array $base
     * @param array $relative
     * @param bool $absolute
     * @param array $expected
     */
    public function testResolve($base, $relative, $absolute, $expected)
    {
        $this->assertSame($expected, Resolver::resolve($base, $relative, $absolute));
    }

    /**
     * @return array
     */
    public function providerResolve()
    {
        return [
            [
                ['one', 'two'],
                ['three', 'four'],
                true,
                ['one', 'two', 'three', 'four'],
            ],
            [
                ['one', 'two'],
                ['..', 'three', '.', 'four'],
                true,
                ['one', 'three', 'four'],
            ],
            [
                ['one'],
                ['..', '..', 'two'],
                true,
                ['two'],
            ],
            [
                ['one'],
                ['..', '..', 'two'],
                false,
                ['..', 'two'],
            ],
        ];
    }
}
