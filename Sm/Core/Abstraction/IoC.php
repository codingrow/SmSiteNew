<?php
/**
 * User: Samuel
 * Date: 2/3/2015
 * Time: 11:04 AM
 */

namespace Sm\Core\Abstraction;

class IoC {
    /** @var  \Sm\Core\View */
    static $view;
    /** @var  \Sm\Core\App */
    static $app;
    /** @var AutoloadInterface */
    static $autoload;
    /** @var  \Sm\Core\Backend */
    static $backend;
    /** @var  \Sm\Core\Response */
    static $response;
    /** @var  \Sm\Storage\Session */
    static $session;
    /** @var  \Sm\Security\Clean */
    static $filter;
    /** @var  \Sm\Development\Benchmark */
    static $benchmark;
    /** @var  \Sm\Core\Util */
    static $util;
    /** @var  \Sm\Core\URI */
    static $uri;
    /** @var  \Sm\Core\Route */
    static $route;
    /** @var  \Sm\Database\SqlModel */
    static $sql_model;
    static protected $registered_classes = [];
    static protected $registered_instances = [];
    static function register($name, $class){
        static::$registered_classes[$name] = $class;
    }
    static function save_instance($instance){
        static::$registered_instances[get_class($instance)] = $instance;
    }

    public static function get_instance($class_type){
        
    }
    static function get_instance_args($class_type, $arguments = []){
        if(isset(static::$registered_classes[$class_type])){
            $class   = static::$registered_classes[$class_type];
            $reflect = new \ReflectionClass($class);
            return $reflect->newInstanceArgs($arguments);
        }
        return new \stdClass();
    }
    static function &get_static_instance($class_type){
        if(isset(static::$registered_classes[$class_type])){
            $index = static::$registered_classes[$class_type];
            if(isset(static::$registered_instances[$index])){
                return static::$registered_instances[$index];
            }
        }
        return new \stdClass();
    }
}