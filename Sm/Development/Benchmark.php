<?php
/**
 * User: Samuel
 * Date: 1/29/2015
 * Time: 12:31 AM
 */

namespace Sm\Development;


class Benchmark {
#array of all benchmark markers and when they were added
    static $marker = array();
    static function mark($name){
        self::$marker[$name] = microtime();
    }
    static function elapsed_time($point1 = '', $point2 = '', $decimals = 4){
        if ($point1 == ''){
            #if the first variable parameter is empty, an output class will swap this value for the elapsed_time of the program
            return '{elapsed_time}';
        }
        if ( ! isset(self::$marker[$point1])){
            return '';
        }
        if ( ! isset(self::$marker[$point2])){
            self::$marker[$point2] = microtime();
        }
        list($sm, $ss) = explode(' ', self::$marker[$point1]);
        list($em, $es) = explode(' ', self::$marker[$point2]);
        return number_format(($em + $es) - ($sm + $ss), $decimals);
    }
}