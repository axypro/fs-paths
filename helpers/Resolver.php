<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\helpers;

/**
 * Helper for resolve path
 */
class Resolver
{
    /**
     * Normalizes a path
     *
     * @param array $components
     * @param bool $absolute [optional]
     * @return array
     */
    public static function normalize($components, $absolute = true)
    {
        $result = [];
        foreach ($components as $c) {
            if ($c === '.') {
                continue;
            }
            if ($c === '..') {
                if (!empty($result)) {
                    $l = array_pop($result);
                    if ($l === '..') {
                        $result[] = '..';
                        $result[] = '..';
                    }
                } elseif (!$absolute) {
                    $result[] = '..';
                }
                continue;
            }
            $result[] = $c;
        }
        return $result;
    }
}
