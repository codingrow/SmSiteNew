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
if ($company = $group->getGroups()) {
    foreach ($company as $key => $group_dealing_with) {
        $group_name = $group_dealing_with->getName();
        $tmp_map = new GroupTransactionMap('group', 'transaction');
        $donation_array = $tmp_map->map($group_dealing_with->getId());
        if ($donation_array) {
            foreach ($donation_array as $value) {
                if ($value) {
                    echo $transaction_date = $value->getCreationDt();
                }
            }

        }
        var_dump($donation_array);
    }
}