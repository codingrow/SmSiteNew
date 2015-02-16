<?php
/**
 * User: Samuel
 * Date: 1/23/2015
 * Time: 1:22 PM
 */

namespace Sm\Core;


/**
 * Class Util- Utility classes for functions that could be used everywhere and aren't specific to a class
 * @package Sm\Core
 */
class Util {
    /** Loop through an array and organize its components recursively
     * @param $array
     * @return bool
     */
    static function recursive_ksort(&$array) {
        foreach ($array as &$value) {
            if (is_array($value))
                static::recursive_ksort($value);
        }
        return ksort($array);
    }
    static function generate_random_string($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-'){
        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count-1)];
        }
        return $str;
    }
    /**
     * @param $array array Array to receive the nested array
     * @param $index string Name of the array index to be added to the new array
     * @return bool
     */
    static function add_inner_array(array &$array, $index) {
        if (isset($array[$index])) {
            return true;
        } else {
            $array[$index] = array();
            return true;
        }
    }

    /**
     * @param $class
     * @return array
     */
    static function iterate_class($class) {
        $ret = [];
        $refclass = new \ReflectionClass($class);
        foreach ($refclass->getProperties() as $property) {
            $name = $property->name;
            if ($property->class == $refclass->name) {
                $ret[] = $name;
            }
        }
        return $ret;
    }
}