<?php
/**
 * User: Samuel
 * Date: 1/28/2015
 * Time: 12:41 PM
 */

namespace Sm\Security;


class Clean {
    static function std(&$variable){
        if(is_array($variable)) {
            foreach ($variable as &$value) {
                    static::std($value);
            }
        }else {
            $variable = htmlspecialchars($variable);
        }
    }
    static function file_name(&$file_name){
        $file_name = str_replace(' ', '_', $file_name);
        $file_name = str_replace('.php', '', $file_name);
        static::std($file_name);
    }
}