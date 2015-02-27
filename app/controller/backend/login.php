<?php
use Model\Password;
use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\Storage\Session;
$func = function($args) {
    $problem_arr = [];
    $user_id = 0;
    /** @var User $user */
    $user = null;
    if (!isset($args['username'])) {
        $problem_arr['user'] = 'Please enter a username';
    }else{
        $username = $args['username'];
        $user = User::find($username);
        $user_id = $user->getId();
        if (!$user_id) {
            $problem_arr['user_password'] = 'username and password do not match';
        }
    }
    if (!isset($args['password'])) {
        $problem_arr['password'] = 'Please enter a password';
    }else{
        $password = $args['password'];
        if (!Password::verify($user_id, $password)) {
            $problem_arr['user_password'] = 'username and password do not match';
        };
    }
    if(!empty($problem_arr)) return $problem_arr;

    IoC::$session->start();
    $user->findGroups();
    if ($groups_arr = $user->getGroups()) {
        $group = array_shift($groups_arr);
        IoC::$session->set('group', $group);
    }
    IoC::$session->set('user', $user);
    return true;
};