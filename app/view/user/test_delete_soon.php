<?php
use Model\Group;
use Sm\Core\Abstraction\IoC;

/**
 * @var $user \Model\User
 */
/**
 * @var $group \Model\User
 */
if (!IoC::$session->get('group')) {
    $user = IoC::$session->get('user');
    $user->findGroups();
    if ($groups_arr = $user->getGroups()) {
        $group = array_shift($groups_arr);
        IoC::$session->set('group', $group);
    }
}
$group = IoC::$session->get('group');
$group->findGroups();
var_dump($group->getGroups());