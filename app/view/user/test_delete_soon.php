<?php
use Sm\Core\Abstraction\IoC;

/**
 * @var $user \Model\User
 */
if ($user = IoC::$session->get('user')) {
    $user->findSettingArr();
    //var_dump($user);
};
