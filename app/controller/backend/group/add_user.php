<?php
/**
 * User: Samuel
 * Date: 3/4/2015
 * Time: 4:39 PM
 */
use Model\UserGroupMap;

if(!function_exists('message')) {
    function message($message, $id = 0, $user_name = 'Unknown User') {
        return ['text' => $message, 'id'=>$id, 'username'=>$user_name];
    }
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
        $ug_map->addRow($user_id, $group_id, 5);
    }

    return message(true);
};