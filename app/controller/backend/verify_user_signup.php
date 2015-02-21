<?php
/**
 * User: Samuel
 * Date: 1/29/2015
 * Time: 1:52 PM
 */
use Model\Password;
use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\Database\SqlModel;
use Sm\Storage\Session;

$func = function ($args) {
    $problem_arr = [];
    $password = null;    $user_identifier = null;    $first_name = null;    $last_name = null;
    if (!isset($args['username']) || !User::is_valid($args['username'])) {
        $problem_arr['username'] = 'Please enter a valid username';
    } else {
        $user_identifier = $args['username'];
        $user = User::find($user_identifier);
        if ($user->getId()) {
            $problem_arr['username'] = 'That username already exists. Please choose another one';
        }
    }
    if (!isset($args['password']) || trim($args['password']) == '') {
        $problem_arr['password'] = 'Please enter a password';
    } else {
        $password = $args['password'];
        if (!Password::is_valid($password)) {
            $problem_arr['password'] = 'Please enter a valid password';
        } else {
            if (!isset($args['password_verify']) || $password !== $args['password_verify']) {
                $problem_arr['password_verify'] = 'Passwords do not match';
            }
        }
    }

    if(!isset($args['first_name']) || trim($args['first_name']) == '') $problem_arr['first_name'] = 'Please enter a first name';
    else $first_name = $args['first_name'];

    if(!isset($args['last_name']) || trim($args['last_name']) == '') $problem_arr['last_name'] = 'Please enter a last name';
    else $last_name = $args['last_name'];

    $primary_email = isset($args['primary_email']) ? $args['primary_email'] : null;

    if (!empty($problem_arr)) {
        return $problem_arr;
    }
    $user = new User();
    $user_settings =
        [
            'username'  =>  $user_identifier,
            'first_name'=>  $first_name,
            'last_name' =>  $last_name, 'primary_email' => $primary_email
        ];
    $user->set($user_settings)->create();
    $user_id =$user->getId();
    if(!$user_id){
        return false;
    }
    #@todo add some sort of verification that the password was added properly?
    Password::add($user_id, $password);
    $user->make_directories($user->getUsername());
    IoC::$session->start();
    IoC::$session->set('user', $user);
    return true;
};