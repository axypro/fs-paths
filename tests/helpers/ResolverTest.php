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
     */
    public function testNormalize($components, $absolute, $expected)
    {
        $this->assertSame($expected, Resolver::normalize($components, $absolute));
    }

    /**
     * @return array
     */
    public function providerNormalize()
    {
        return [
            [
                ['one', 'two', 'three', '..', 'four', '.', 'five'],
                true,
                ['one', 'two', 'four', 'five'],
            ],
            [
                ['one', 'two', '..', 'three', '..', '..', '..', '..', 'four', 'five', '..', 'six'],
                true,
                ['four', 'six'],
            ],
            [
                ['one', 'two', '..', 'three', '..', '..', '..', '..', 'four', 'five', '..', 'six'],
                false,
                ['..', '..', 'four', 'six'],
            ],
            [
                ['one', '..', '..', '..', 'three', '..', '..', '..', 'four', 'five', '.'],
                false,
                ['..', '..', '..', '..', 'four', 'five'],
            ],
        ];
    }
}
