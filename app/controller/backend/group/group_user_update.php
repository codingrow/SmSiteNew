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
    function message($message, $id = 0, $user_name = 'Unknown User') {
        return ['text' => $message, 'id' => $id, 'username' => $user_name];
    }
}

$func = function ($args) {
    $permitted_user_info_update_array = ['role_id'];
    $user_info = isset($args['user_info']) ? $args['user_info'] : [];

    if (isset($args['group_id'])) {
        $group_id = $args['group_id'];
    } else {
        return message('we could not find the group to add the users to');
    }

    if (isset($args['user_id'])) {
        $user_id = $args['user_id'];
    } else {
        return message('we could not find one of the users you tried to update');
    }
    /** @var User $this_user */
    $this_user = IoC::$session->get('user');

    $user_to_delete = User::find($user_id);
    if ($user_to_delete->getId() == 0) {
        return message('we could not find member', $user_id);
    }


    $group = Group::find($group_id);
    $group_users = $group->findUsers()->getUsers();


    if (!array_key_exists($this_user->getUsername(), $group->getUsers())) {
        return message('you must be a part of the group', $this_user->getId(), $this_user->getUsername());
    }
    $this_user_role = $group_users[$this_user->getUsername()]->getGroupContext()['role_id'];
    $user_to_delete_role = $group_users[$user_to_delete->getUsername()]->getGroupContext()['role_id'];
    if ($this_user_role > 4) {
        return message('you are not authorized to update users', $this_user->getId(), $this_user->getUsername());
    }
    if ($this_user_role != 1 and $this_user_role <= $user_to_delete_role) {
        return message('you are not authorized to update this user', $user_to_delete->getId(), $user_to_delete->getUsername());
    }


    $othermap = new UserGroupMap('user', 'group');
    $othermap->setId($user_id);
    foreach ($user_info as $key => $value) {
        if (!in_array($key, $permitted_user_info_update_array) or (!is_string($value) or (($value = trim($value)) == ''))) {
            continue;
        }
        if ($key == 'role_id') {
            if($user_id == $this_user->getId()){
                return message('You cannot update your own role', $user_to_delete->getId(), $user_to_delete->getUsername());

            }
            if($value < $this_user_role){
                return message('you are not authorized to promote a user to a position higher than yourself', $user_to_delete->getId(), $user_to_delete->getUsername());
            }
            if($value < $user_to_delete_role and $this_user_role == $user_to_delete_role){
                return message('you are not authorized to update this user\'s role in this manner.', $user_to_delete->getId(), $user_to_delete->getUsername());
                continue;
            }
    }
        $othermap->set($key, $value);
    }
    if ($othermap->has_been_changed()) {
        $othermap->save();
        return message(true, $user_id);
    }
    return message('nothing has changed', $user_id);

//    ->setRole(1)->save();
};