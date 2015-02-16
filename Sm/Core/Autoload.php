<?php
/**
 * User: Samuel
 * Date: 1/22/2015
 * Time: 9:04 PM
 */

namespace Sm\Core;

use Sm\Core\Abstraction\AutoloadInterface;

/**
 * Class Autoload
 * Adds and removes rules from the spl_autoload registry
 * @package Sm\Core
 */
class Autoload implements AutoloadInterface{
    static $registry = [];
    function __construct() {
        static::add_rule('default_autoload', (['static','default_autoload' ]));
    }
    protected static function default_autoload($class = ""){
        $this_namespace = explode('\\', __NAMESPACE__)[0];
        if(0 === strpos($class, $this_namespace) && is_file($class.'.php')) {
            require_once($class.'.php');
        }elseif(is_file('app/'.$class.'.php')){
            require('app/'.$class.'.php');
        }
    }
    static function instance(){
        return new static;
    }
    static function add_rule($name, callable $callback){
        if(!isset(static::$registry[$name]))   static::$registry[$name] = $callback;
    }
    static function remove_rule($name){
        if(isset(static::$registry[$name])){
            unset (static::$registry[$name]);
            return true;
        }else{
            return false;
        }
    }
    function register(){
        foreach(static::$registry as $k=>$callback){
            spl_autoload_register($callback);
        }
        return $this;
    }
}