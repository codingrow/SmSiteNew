<?php
use Sm\Core\Abstraction\IoC;

/** @var \Model\User $user */
if ($user = IoC::$session->get('user')) {
    $groups_arr = $user->findGroups();
    $current_group = array_shift($groups_arr);
    var_dump($current_group);
}
?>
lsfhuiadhufi