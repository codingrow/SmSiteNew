<?php
/**
 * User: Samuel
 * Date: 2/4/2015
 * Time: 11:26 AM
 */

namespace Sm\Core\Abstraction;


interface SessionInterface {
    static function start();
    static function clear();
    static function get($name, $cache);
    static function set($name, $value);
}