<?php
/**
 * User: Samuel
 * Date: 1/28/2015
 * Time: 12:41 PM
 */

namespace Sm\Security;


class Clean {
    static function file_name(&$file_name) {
        $file_name = str_replace(' ', '_', $file_name);
        $file_name = str_replace('.php', '', $file_name);
        static::std($file_name);
    }

    static function std(&$variable) {
        if (is_array($variable)) {
            foreach ($variable as &$value) {
                static::std($value);
            }
        } else {
            $variable = htmlspecialchars($variable);
        }
    }

    static function url(&$str, $replace = [], $delimiter = '_') {
        setlocale(LC_ALL, 'en_US.UTF8');
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $str = $clean;
    }
}