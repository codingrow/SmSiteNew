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
$user = User::find(IoC::$session->get('user_id'));
$user->findAvailableUsers();
var_dump($user->getAvailableUsersSql());