<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:54 PM
 */
use Model\Entity;
use Model\Group;
use Model\GroupEntityMap;
use Model\GroupGroupMap;
use Model\Password;
use Model\User;
use Sm\Core\Abstraction\IoC;

$func = function ($args) {
    $name = isset($args['name']) ? $args['name'] : null;
    $address = isset($args['address']) ? $args['address'] : null;
    $phone_number = isset($args['phone_number']) ? $args['phone_number'] : null;
    $tax_code = isset($args['tax_code']) ? $args['tax_code'] : null;
    $url = isset($args['url']) ? $args['url'] : null;
    $contact_name = isset($args['contact_name']) ? $args['contact_name'] : null;
    $description = isset($args['description']) ? $args['description'] : null;


    if ($name != null):
        /** @var Group $session_group */
        $session_group = IoC::$session->get('group');
        /** @var Group $session_group */
        if (!$session_group) {
            return false;
        }
        $time = new DateTime();
        $time->getTimestamp();
        $user_settings = ['name' => $name, 'description' => $description, 'type' => 2, 'alias' => str_replace(' ', '_', $name)];
        $group = new Group();
        $group->set($user_settings)->create();

        $entity = new Entity();
        $entity->set(['address' => $address, 'phone_number' => $phone_number, 'url' => $url, 'description' => $description, 'contact_name' => $contact_name, 'tax_code' => $tax_code])->create();

        $group_id = $group->getId();
        if (!$group_id) {
            return false;
        }
        $id = $entity->getId();
        if ($id) {
            $group_entity_map = new GroupEntityMap();
            $group_entity_map->addRow($group_id, $id);
        }
        $g_g_map = new GroupGroupMap();
        $g_g_map->addRow($group_id, $session_group->getId());
        $group->findEntity();
        //var_dump($group);
    endif;
    var_dump($args);
    return true;
};