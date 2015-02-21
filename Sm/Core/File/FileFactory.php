<?php
/**
 * User: Samuel
 * Date: 2/20/2015
 * Time: 4:17 PM
 */

namespace Sm\Core\File;


use Sm\Core\Abstraction\IoC;

class FileFactory {
    static function create($file_post) {
        static::process($file_post);
    }

    static private function process($file_post) {
        $file_ary = array();
        $file_obj = new File();
        if (!is_array($file_post['name'])) {
            foreach ($file_post as $key => $value) {
                $file_post[$key] = [$value];
            }
        }
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        for ($i = 0; $i < $file_count; $i++) {
            $ext = $file_obj->guess_extension($file_post['name'][$i]);
            if (!$file_obj->verify_extension($ext, $file_post['type'][$i])) {
                continue;
            }
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
            $server_name = 'u' . IoC::$util->generate_random_string(20);
            $file_ary[$i]['server_name'] = $server_name . $ext;
        }
        return $file_post = $file_ary;
    }
}