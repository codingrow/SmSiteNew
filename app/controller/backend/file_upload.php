<?php
/**
 * User: Samuel
 * Date: 1/31/2015
 * Time: 1:57 PM
 */
use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\File\File;

$func = function($args){
    try{
        /** @var User $user */
        if(!$user = IoC::$session->get('user')){
            throw new Exception('Invalid Session', 1);
        }
        $exception_arr = [];
        $username = $user->getUsername();
        if(!is_dir($target_dir = USER_PATH.'user/'.$username.'/files/'))
            User::make_directories($user->getUsername());

        if(!is_dir($target_dir = USER_PATH.'user/'.$username.'/files/'))
            $exception_arr['directory'] = 'Could not save file';

        if(isset($args['files'])){
            foreach ($args['files'] as &$file) {
                File::process($file);
            }
            IoC::$util->recursive_ksort($args['files']);
            if(empty($args['files'])){
                $exception_arr['file'] = 'Nonexistent file';
            }
            foreach ($args['files'] as $key => $value) {
                foreach ($value as $array) {
                    $folder = strpos($array['type'], 'image') === 0 ? 'img/' : (strpos($array['type'], 'text/css')===0 ? 'css/' : '');
                    $upload_path = ($target_dir.$folder.($array['server_name']));
                    if (!move_uploaded_file($array['tmp_name'], $upload_path)) {
                        $exception_arr['move_file'] = 'Could not save file';
                        continue;
                    }
                    if($folder == 'img/'){
                        $user->addImage($array['name'], $array['server_name']);
                    }
                }
            }
            if(!empty($exception_arr)){
                return $exception_arr;
            }
            return true;
        }else{
            throw new Exception('No files to upload!', 2);
        }
    }catch (Exception $e){
        return false;
    }


};