<?php
/**
 * User: Samuel
 * Date: 3/14/2015
 * Time: 12:19 PM
 */
use Model\Group;
use Model\User;
use Model\UserGroupMap;
use Sm\Core\Abstraction\IoC;

if (!function_exists('message')) {
    //todo replace with exception kind of class
    function message($message, $id = 0, $user_name = 'Unknown User') {
        return ['text' => $message, 'id' => $id, 'username' => $user_name];
    }
}

$func = function ($args) {
    $permitted_user_info_update_array = ['role_id'];
    $user_info = isset($args['user_info']) ? $args['user_info'] : [];

    if (isset($args['group_id'])) {
        $group_id = $args['group_id'];
        $group = Group::find($group_id);
        $group_users = $group->findUsers()->getUsers();
    } else {
        return message('we could not find the group to add the users to');
    }

    if (isset($args['user_id'])) {
        $utd_id = $args['user_id'];
        $utd = User::find($utd_id);
        if ($utd_id == 0) {
            return message('we could not find member', $utd_id);
        }
        $utd_username = $utd->getUsername();
        $utd_role = $group_users[$utd_username]->getGroupMapping($group->getAlias())->getRoleId();

    } else {
        return message('we could not find one of the users you tried to update');
    }
    $this_user = User::find(IoC::$session->get('user_id'));
    $this_username = $this_user->getUsername();


    if (!array_key_exists($this_username, $group_users)) {
        return message('you must be a part of the group', $this_user->getId(), $this_username);
    }
    $this_user_role = $group_users[$this_username]->getGroupMapping($group->getAlias())->getRoleId();
    if ($this_user_role > 4) {
        return message('you are not authorized to update users', $this_user->getId(), $this_username);
    } elseif ($this_user_role != 1 and $this_user_role <= $utd_role) {
        return message('you are not authorized to update this user', $utd_id, $utd_username);
    }


    $othermap = new UserGroupMap('user', 'group');
    $othermap->setId($utd_id);
    foreach ($user_info as $key => $value) {
        if (!in_array($key, $permitted_user_info_update_array) or (!is_string($value) or (($value = trim($value)) == ''))) {
            continue;
        }
        if ($key == 'role_id') {
            if ($utd_id == $this_user->getId()) {
                return message('You cannot update your own role', $utd_id, $utd_username);
            } elseif ($value < $this_user_role) {
                return message('you are not authorized to promote a user to a position higher than yourself', $utd_id, $utd_username);
            } elseif ($value < $utd_role and $this_user_role == $utd_role) {
                return message('you are not authorized to update this user\'s role in this manner.', $utd_id, $utd_username);
            }
        }
        $othermap->set($key, $value);
    }
    if ($othermap->has_been_changed()) {
        $othermap->save();
        return message(true, $utd_id, $utd_username);
    }
    return message('nothing has changed', $utd_id);
};