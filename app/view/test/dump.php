<?php
/**
 * User: Samuel
 * Date: 3/1/2015
 * Time: 3:34 AM
 */
use Model\User;
use Sm\Core\Abstraction\IoC;

var_dump($_POST);
/** @var User $user */
if ($user = IoC::$session->get('user')) {
    $user->findAvailableUsers();
    var_dump($user->getAvailableUsersSql());
}