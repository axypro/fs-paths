<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\params;

/**
 * Additional parameters of an URL-path
 *
 * For example: http://example.com/folder/file.txt?x=1#h1
 * scheme: http
 * authority: example.com
 * query: x=1
 * fragment: h1
 *
 * path is "/folder/file.txt"
 */
class URL extends Base
{
    /**
     * The scheme
     *
     * @var string
     */
    public $scheme;

    /**
     * The authority
     *
     * @var string
     */
    public $authority;

    /**
     * The query string
     *
     * @var string
     */
    public $query;

    /**
     * The fragment
     *
     * @var string
     */
    public $fragment;
}
