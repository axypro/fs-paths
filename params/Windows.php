<?php
/**
 * @package axy\fs\paths
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\fs\paths\params;

/**
 * Additional parameters of a Windows-path
 */
class Windows extends Base
{
    /**
     * A disc name
     *
     * For server path and for relative path the disc is NULL
     *
     * @var string
     */
    public $disc;

    /**
     * A server name
     *
     * For local path and for relative path the server is NULL
     *
     * @var string
     */
    public $server;
}
