<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:54 PM
 */
use Model\Group;
use Model\GroupGroupMap;
use Model\Password;
use Model\User;
use Sm\Core\Abstraction\IoC;

$func = function ($args) {
    $name = isset($args['name']) ? $args['name'] : null;
    $address = isset($args['address']) ? $args['address'] : null;
    $phone_number = isset($args['phone_number']) ? $args['phone_number'] : null;
    $tax_code = isset($args['tax_code']) ? $args['tax_code'] : null;
    $last_name = isset($args['last_name']) ? $args['last_name'] : null;

    $contact_name = isset($args['contact_name']) ? $args['contact_name'] : null;
    $description = isset($args['description']) ? $args['description'] : null;
    if ($name != null):
        /** @var Group $session_group */
        $session_group = IoC::$session->get('group');
        if ($session_group == false) {
            return false;
        }
        $user_settings = ['name' => $name, 'description' => $description, 'type' => 2];
        $group = new Group();
        $group->set($user_settings)->create();
        var_dump($group);
        $group_id = $group->getId();
        if (!$group_id) {
            return false;
        }

        $g_g_map = new GroupGroupMap();
        $g_g_map->addRow($group_id, $session_group->getId());
    endif;

    var_dump($args);
    return true;
};