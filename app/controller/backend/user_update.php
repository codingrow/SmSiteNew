<?php
/**
 * User: Samuel
 * Date: 2/6/2015
 * Time: 1:25 PM
 */
use Sm\Core\Abstraction\IoC;

$func = function($args){
    /** @var Model\User $user */
    $permitted_user_info_update_array =
        [
            'first_name',
            'last_name'
        ];
    $user_info = isset($args['user_info']) ? $args['user_info'] : [];
    $user = IoC::$session->get('user');
    if($user){
        foreach ($user_info as $key => $value) {
            if(!in_array($key, $permitted_user_info_update_array) or  (!is_string($value) or (($value = trim($value)) == ''))){
                unset($user_info[$key]);
            }
        }
    }
    return true;
};