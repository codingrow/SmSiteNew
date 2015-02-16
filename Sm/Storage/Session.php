<?php
/**
 * User: Samuel
 * Date: 1/27/2015
 * Time: 1:21 AM
 */

namespace Sm\Storage;
use Sm\Core\Abstraction\SessionInterface;


/**
 * Class Session
 * Serves as an interface for potential session-related variables. Meant to interact with Cache class.
 * @package Sm\Storage
 */
class Session implements SessionInterface{

    /**
     *
     */
    function __construct() {
        static::start();
    }
    static function start(){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }
    /**
     * @param string $name  variable name to retrieve
     * @param bool $cache Whether or not to retrieve something from the cache if it exists
     * @todo implement cache
     */
    static function get($name, $cache = true){
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    /**
     * @param      $name
     * @param      $value
     */
    static function set($name, $value){
        $_SESSION[$name] = $value;
    }

    static function clear(){
        if(session_status() == PHP_SESSION_ACTIVE){
            session_regenerate_id();
            session_destroy();
            session_start();
        }

    }
}