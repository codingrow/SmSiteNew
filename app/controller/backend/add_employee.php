<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:54 PM
 */
use Model\Password;
use Model\User;

$func = function ($args) {
    $username = isset($args['username']) ? $args['username'] : null;
    $first_name = isset($args['first_name']) ? $args['first_name'] : null;
    $last_name = isset($args['last_name']) ? $args['last_name'] : null;
    $password = isset($args['password']) ? $args['password'] : null;
    $primary_email = isset($args['primary_email']) ? $args['primary_email'] : null;

    $user_settings = ['username' => $username, 'first_name' => $first_name, 'last_name' => $last_name, 'primary_email' => $primary_email, 'type' => 1];
    $user = new User();
    $user->set($user_settings)->create();
    $user_id = $user->getId();
    if (!$user_id) {
        return false;
    }
    Password::add($user_id, $password);
    $user->make_directories($user->getUsername());

    var_dump($args);
};