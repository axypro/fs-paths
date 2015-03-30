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
     * @param bool $changed [optional]
     * @return array
     */
    public static function normalize($components, $absolute = true, &$changed = false)
    {
        $result = [];
        $changed = false;
        foreach ($components as $c) {
            if ($c === '.') {
                $changed = true;
                continue;
            }
            if ($c === '..') {
                $changed = true;
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

    /**
     * Resolves a relative path
     *
     * @param array $base
     * @param array $relative
     * @param bool $absolute
     * @return array
     */
    public static function resolve($base, $relative, $absolute = true)
    {
        $components = array_merge($base, $relative);
        return self::normalize($components, $absolute);
    }
}
