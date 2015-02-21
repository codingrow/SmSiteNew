<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:54 PM
 */
use Model\Password;
use Model\User;

$func = function ($args) {
    $args = $args[0];
    $name = isset($args['name']) ? $args['name'] : null;
    $address = isset($args['address']) ? $args['address'] : null;
    $contact_name = isset($args['contact_name']) ? $args['contact_name'] : null;
    $url = isset($args['password']) ? $args['password'] : null;
    $tax_code = isset($args['tax_code']) ? $args['tax_code'] : null;
    $phone_number = isset($args['phone_number']) ? $args['phone_number'] : null;
    if ($name != null):
        $user_settings = ['name' => $name, 'address' => $address, 'contact_name' => $contact_name, 'tax_code' => $tax_code, 'type' => 2, 'phone_number' => $phone_number];
        $user = new User();
        $user->set($user_settings)->create();
        var_dump($user);
        $user_id = $user->getId();
        if (!$user_id) {
            return false;
        }
        Password::add($user_id, $url);
        $user->make_directories($user->getUsername());
    endif;

    var_dump($args);
    return true;
};