<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:00 AM
 */
use Model\Group;
use Model\Password;
use Model\User;
use Model\UserGroupMap;
use Sm\Core\Abstraction\IoC;

$func = function ($args) {
    $problem_arr = [];
    $group_alias = null;
    $name = null;
    /** @var User $user */
    $user = &IoC::$session->get('user');
    $user_id = isset($args['user_id']) ? $args['user_id'] : $user ? $user->getId() : null;
    if (!$user_id) {
        $problem_arr['user'] = 'We cannot seem to find this user... Are they still an active member?';
    } else {
        $user = $user ? $user : User::find($user_id);
    }
    if ($user) {
        if (!isset($args['name']) || trim($args['name']) == '') {
            $problem_arr['name'] = 'Please enter a group name ';
        } else $name = $args['name'];

        if (!empty($problem_arr)) {
            return $problem_arr;
        }
        $type = isset($args['type']) ? $args['type'] : 1;
        $name_before = $name;
        $group_alias = Group::create_alias($name, $user);
        if (!Group::exists($group_alias)) {
            $group = new Group();
            $group_settings = ['name' => $name_before, 'type' => $type, 'alias' => $group_alias, 'founder_id' => $user->getId(), 'description' => isset($args['description']) ? $args['description'] : ''];
            $group->set($group_settings)->create();

            if ($group_id = $group->getId()) {
                $ug_map = new UserGroupMap('user', 'group');
                $ug_map->addRow($user_id, $group_id, 1);
            }

            $user->findGroups();
            IoC::$session->set('user', $user);
        } else {
            return ['name' => 'It looks like you already have a group with that name...'];
        }
    }

    return true;
};