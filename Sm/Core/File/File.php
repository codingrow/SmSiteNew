<?php
/**
 * User: Samuel
 * Date: 2/2/2015
 * Time: 9:35 PM
 */

namespace Sm\Core\File;


use Sm\Core\Abstraction\FileInterface;

class File implements FileInterface{
    static $permitted_mime_arr;
    /**
     * Based solely on  a provided string, try to guess what the extension will be
     * @param string $string the subject whose extension is to be guessed
     * @return string The extension in the format-->  .extension
     */
    public function guess_extension($string) {
        $string = strrev($string);
        return '.' . strrev(stristr($string, '.', true));
    }

    public function verify_extension($extension, $mime) {
        $extension = ltrim($extension, '.');
        if (array_key_exists($extension, static::$permitted_mime_arr)) {
            if (is_array(static::$permitted_mime_arr[$extension]) && in_array($mime, static::$permitted_mime_arr[$extension])) {
                return true;
            } else {
                if (static::$permitted_mime_arr[$extension] == $mime) {
                    return true;
                }
            }
        }
        return false;
    }
}