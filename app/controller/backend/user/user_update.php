<?php
/**
 * User: Samuel
 * Date: 2/6/2015
 * Time: 1:25 PM
 */
use Model\User;
use Sm\Core\Abstraction\IoC;

$func = function($args){
    /** @var Model\User $user */
    $problem_arr = [];
    $permitted_user_info_update_array =
        [
            'first_name', 'last_name', 'primary_email'
        ];
    $user_info = isset($args['user_info']) ? $args['user_info'] : [];
    $user = IoC::$session->get('user');
    if($user){
        if (isset($user_info['primary_email']) and $user_info['primary_email'] !== $user->getPrimaryEmail()) {
            if (User::exists($user_info['primary_email'], 'primary_email')) {
                $problem_arr['primary_email'] = 'There is already a user with that email!';
                unset($user_info['primary_email']);

            }
        }
        foreach ($user_info as $key => $value) {
            if (!in_array($key, $permitted_user_info_update_array) or (!is_string($value) or (($value = trim($value)) == '')) or $value == $user->get($key)) {
                continue;
            }
            $user->set($key, $value);
        }
        if (!empty($problem_arr))
            return $problem_arr;
        if (!$user->has_been_changed()) {
            return true;
        }
        $user->save();
    } else {
        IoC::$response->redirect(IoC::$uri->url('user/login'));
    }

    return true;
};