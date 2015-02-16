<?php
/**
 * User: Samuel
 * Date: 1/25/2015
 * Time: 12:14 AM
 */

namespace Sm\Core;


class Response {
    static $headers = ['content-type'=>'text/html'];
    static function header($type, $value, $append = true){
        $type = strtolower($type);
        if($append == true){
            static::$headers[$type] = $value;
        }else{
            static::$headers = [$type=>$value];
        }
    }
    static function clear_screen(){
        if(ob_get_level()) {
            ob_clean();
        }else{
            ob_start();
            ob_clean();
        }
    }
    static function end_ob(){
        $level = ob_get_level();
        for($i = 0; $i < $level ; $i++){
            ob_end_clean();
        }
    }
    /**
     * @param     $url
     * @param int $code
     */
    static function redirect($url, $code = 404){
        static::clear_screen();
        header('location: '.$url);
        #exit;
    }
    static function message($string) {
    }
    static function get_headers($type = "header"){
        $str = '';
        foreach (static::$headers as $key => $value) {
            $str .= $key.': '.$value.';';
        }

        switch($type){
            case "header":
                if($str != '')
                header($str);
            case "str":
                return $str;
                break;
            default:
            case "arr":
                return static::$headers;
                break;
        }
    }
}