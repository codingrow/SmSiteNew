<?php
use Model\Group;
use Model\GroupTransactionMap;
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