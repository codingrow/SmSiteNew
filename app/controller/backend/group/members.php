<?php
/**
 * User: Samuel
 * Date: 3/4/2015
 * Time: 1:32 PM
 */

use Model\Group;

$func = function ($args = '') {
    $group = Group::find($args['group']);
    $group->findUsers();
    $users = $group->getUsers();
    $arr = [];
    foreach ($users as $username => $user) {
        $arr[] = $username;
    }
    return $arr;
};