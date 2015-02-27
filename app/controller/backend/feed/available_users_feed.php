<?php
/**
 * User: Samuel
 * Date: 2/26/2015
 * Time: 2:09 PM
 */
use Model\User;
use Sm\Core\Abstraction\IoC;

$func = function () {
    if ($user = IoC::$session->get('user')) {
        /** @var User $user */
        $feed = $user->getAvailableUsersSql();
        foreach ($feed as &$value) {
            unset($value['update_dt']);
        }
        return $feed;
    }
};