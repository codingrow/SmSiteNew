<?php
/**
 * User: Samuel
 * Date: 1/24/2015
 * Time: 7:51 PM
 */

namespace Sm\Core;


class URI {
    static protected $uri_string;
    static $remove = 'SmSiteNew';
    static $ip = '172.16.61.246';
    static function get_uri_string(){
        $uri = function(){
            $tmp = trim($_SERVER['REQUEST_URI'], '/');
//            if(strpos($tmp, static::$ip) !== -1){
//                $remove = static::$ip;
//            }else{
                $remove = static::$remove;
//            }
            return substr($tmp, strpos($tmp, $remove) + strlen($remove)+1);
        };
        return isset(static::$uri_string) ? static::$uri_string : static::$uri_string = $uri();
    }
    static function filter_uri(){

    }
    static function detect_uri(){}
    static function url($url, $type = 'std'){
        switch ($type){
            case 'js':
                return RESOURCE_URL.'js/'.$url;
            case 'css':
                return RESOURCE_URL . 'css/' . $url;
            default:
            case 'std': return MAIN_URL.$url;
        }
    }
}