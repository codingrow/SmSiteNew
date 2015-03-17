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

if(!function_exists('message')) {
    function message($message, $id = 0, $user_name = 'Unknown User') {
        return ['text' => $message, 'id'=>$id, 'username'=>$user_name];
    }
}
$func = function ($args) {
    if (isset($args['group_id'])) {
        $group_id = $args['group_id'];
    } else {
        return message('we could not find the group to delete the users from');
    }

    if (isset($args['user_id'])) {
        $user_id = $args['user_id'];
    } else {
        return message('we could not find one of the users you tried to delete');
    }
    /** @var User $this_user */
    $this_user = IoC::$session->get('user');

    $user_to_delete = User::find($user_id);
    if ($user_to_delete->getId() == 0) {
        return message('we could not find member', $user_id);
    }


    $group = Group::find($group_id);
    $group_users = $group->findUsers()->getUsers();

    if (!array_key_exists($this_user->getUsername(), $group->getUsers()) or ($group_users[$this_user->getUsername()]->getGroupContext()['role_id'] != 1 and $this_user->getId() != $user_id)
    ) {
        return message("it doesn't look like you are authorized to remove this member", $user_id);
    }

    $ug_map = new UserGroupMap('group', 'user');
    if (!$group_users[$user_to_delete->getUsername()]) {
        return message('this user is already not a part of this group', $user_id, $user_to_delete->getUsername());
    }
    if ($group_users[$user_to_delete->getUsername()]->getGroupContext()['role_id'] == 1) {
        $is_another_leader = false;
        foreach ($group_users as $username => $user) {

            if ($username != $user_to_delete->getUsername() and $user->getGroupContext()['role_id'] == 1) {
                $is_another_leader = true;
                break;
            }
        }
        if (!$is_another_leader)
            return message('you cannot delete the only owner of the group!', $user_id, $user_to_delete->getUsername());
    }
    $ug_map->delRow($user_id, $group_id);
    return message(true, $user_id, $user_to_delete->getUsername());
};