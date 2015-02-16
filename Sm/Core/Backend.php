<?php
/**
 * User: Samuel
 * Date: 1/27/2015
 * Time: 11:06 PM
 */

namespace Sm\Core;


class Backend {
    static function run($filename, $args = []){
        include BASE_PATH.'app/controller/backend/'.$filename.'.php';
        if(isset($func) && is_callable($func)){
            return $func($args);
        }return false;
        #return true;
    }
}