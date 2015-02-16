<?php
/**
 * User: Samuel
 * Date: 1/21/2015
 * Time: 1:36 PM
 */

namespace Sm\Storage;

#TODO add a config-based switch related to which caching mechanism we will be using
/**
 * Class Cache
 * Meant to serve as an abstraction of caching for a variety of potential caching mechanisms
 * @todo make more available for a wider variety of caching tools (memcache, APC, etc.)
 * @package Sm\Storage
 */
class Cache {
    /** Writes a variable to the cache.
     * @param $key           string     The name of the variable to be stored in the cache
     * @param $value         mixed      The actual variable to be cached
     * @param $expiration_dt int   The date for the variable cache to expire
     * @return bool
     */
    static function write($key, $value, $expiration_dt){
        return true;
    }

    /** Retrieves a value, by key, from the cache
     * @param $key
     * @return bool
     */
    static function get($key){
        return false;
    }

    /** The same idea as Cache::write but returning false if there is already a variable with that key
     *  This differs from the write function in that it will not overwrite any values that already are set
     * @see Cache::write
     * @param $key           string     The name of the variable to be stored in the cache
     * @param $value         mixed      The actual variable to be cached
     * @param $expiration_dt int   The date for the variable cache to expire
     * @return bool
     */
    static function add($key, $value, $expiration_dt){
        return true;
    }
}