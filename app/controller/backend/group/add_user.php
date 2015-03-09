<?php
/**
 * User: Samuel
 * Date: 3/4/2015
 * Time: 4:39 PM
 */
use Model\UserGroupMap;

function message($message) {
    return ['text' => $message];
}

$func = function ($args) {
    if (isset($args['group_id'])) {
        $group_id = $args['group_id'];
    } else {
        return message('Cannot find group');
    }

    if (isset($args['user_add'])) {
        $user_add = $args['user_add'];
    } else {
        return message('User');
    }


    $ug_map = new UserGroupMap('group', 'user');
    foreach ($user_add as $user_id) {
        $ug_map->addRow($user_id, $group_id, 2);
    }

    return message(true);
};