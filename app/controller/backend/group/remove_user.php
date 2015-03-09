<?php
/**
 * User: Samuel
 * Date: 3/5/2015
 * Time: 1:38 PM
 */
use Model\Group;
use Model\User;
use Model\UserGroupMap;
use Sm\Core\Abstraction\IoC;

function message($message) {
    return ['text' => $message];
}

$func = function ($args) {
    if (isset($args['group_id'])) {
        $group_id = $args['group_id'];
    } else {
        return message('Cannot find the group');
    }

    if (isset($args['user_id'])) {
        $user_id = $args['user_id'];
    } else {
        return message('Cannot find  member');
    }
    /** @var User $this_user */
    $this_user = IoC::$session->get('user');

    $user_to_delete = User::find($user_id);
    if ($user_to_delete->getId() == 0) {
        return message('Cannot find member');
    }


    $group = Group::find($group_id);
    $group_users = $group->findUsers()->getUsers();

    if (!array_key_exists($this_user->getUsername(), $group->getUsers()) or ($group_users[$this_user->getUsername()]->getGroupContext()['role_id'] != 1 and $this_user->getId() != $user_id)
    ) {
        return message("User not authorized to remove this member");
    }

    $ug_map = new UserGroupMap('group', 'user');
    if (!$group_users[$user_to_delete->getUsername()]) {
        return message('Do they even go here?');
    }
    if ($group_users[$user_to_delete->getUsername()]->getGroupContext()['role_id'] == 1) {
        $is_another_leader = false;
        foreach ($group_users as $username => $user) {
            if ($username != $user_to_delete->getUsername() and $user->getGroupContext()['role_id'] === 1) {
                $is_another_leader = true;
                break;
            }
        }
        if (!$is_another_leader)
            return message('Cannot delete the only owner of the group!');
    }
    $ug_map->delRow($user_id, $group_id);
    return ['text' => true];
};