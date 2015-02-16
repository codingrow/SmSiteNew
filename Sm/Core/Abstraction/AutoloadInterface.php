<?php
/**
 * User: Samuel
 * Date: 2/4/2015
 * Time: 11:33 AM
 */

namespace Sm\Core\Abstraction;


/**
 * Interface AutoloadInterface
 * @package Sm\Core\Abstraction
 */
interface AutoloadInterface {
    /**
     * @return mixed
     */
    static function instance();

    /**
     * Add an autoload rule to be registered
     * @param          $name
     * @param callable $callback
     * @return mixed
     */
    static function add_rule($name, callable $callback);

    /**
     * Remove an autoload rule before it is registered
     * @param $name
     * @return mixed
     */
    static function remove_rule($name);

    /**
     * Register all of the added rules
     * @return mixed
     */
    function register();
}