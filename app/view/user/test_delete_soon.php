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
$group = IoC::$session->get('group');
$group->findGroups();


if ($g = $group->getGroups()) {
    foreach ($g as $key => $value) {
        $tmp_map = new GroupTransactionMap('group', 'transaction');
        $f = $tmp_map->map($value->getId());
        var_dump($f);
    }


}