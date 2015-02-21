<?php
/**
 * User: Samuel
 * Date: 1/22/2015
 * Time: 2:12 PM
 */

namespace Sm\Core;

use Sm\Core\Abstraction\IoC;

class App {
    const VERSION = '1.0.0';
    private static $is_boot = false;
    static $views;
    private static $hooks = [];
    static function boot(){
        ob_start();
        self::$is_boot = true;
    }
    static function is_boot(){
        return self::$is_boot;
    }
    static function add_hook($title, callable $hook){
        self::$hooks[$title] = $hook;
    }
    static function call_hook($hook){
        if(isset(self::$hooks[$hook]))return call_user_func(self::$hooks[$hook]);
        return false;
    }
    static function run(){
        self::call_hook('pre_controller');
        $callback_arr   = IoC::$route->get_callback();
        $result = call_user_func_array($callback_arr[0], $callback_arr[1]);
        if($result instanceof View || $result === null){
            if(!$result){
                $result = IoC::$view->get_content();
            }else{
                $result = $result->get_content();
            }
            if(!IoC::$view->view_exists('header')){
                $content = IoC::$view->create('template/std_tcc_header', [], 'header')->content;
                IoC::$view->replace($result, '{{nest_header}}', $content);
            }
            $viewData = IoC::$view->getViewData();
            $result = str_replace(array_keys($viewData),array_values($viewData), $result );
        }elseif(is_bool($result)){
            return $result;
        }elseif(!is_string($result)){
            $result = json_encode($result);
        }
        IoC::$benchmark->mark('end');
        $result = str_replace('{elapsed_time}', IoC::$benchmark->elapsed_time('start', 'end'), $result);
        Response::get_headers();
        echo $result;
        return true;
    }
}