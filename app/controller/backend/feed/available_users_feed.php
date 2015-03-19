<?php
/**
 * User: Samuel
 * Date: 2/28/2015
 * Time: 8:15 PM
 */
use Model\User;
use Sm\Core\Abstraction\IoC;

$func = function () {
    $user = User::find(IoC::$session->get('user_id'));

    $arr = ['test1', 'test2', 'test3', 'test4'];
    if ($user != false && !empty($group_arr = $user->getAvailableUsersSql())) {
        $arr = [];
        foreach ($group_arr as $key => $value) {
            $arr[$value['username']] = ['id' => $value['id'], 'text' => $value['username']];
        }
    }
    $new_arr = [];
    if (isset($_GET['q']) and trim($_GET['q']) !== '') {
        if ($_GET['q'] == '*') {
            $new_arr = $arr;
        } else {
            foreach ($arr as $value) {
                if (strpos(strtolower($value['text']), strtolower($_GET['q'])) !== false) {
                    $new_arr[] = $value;
                }
            }
        }
    } else {
        $new_arr = $arr;
    }
    ksort($new_arr);
    return ['results' => array_values($new_arr)];
};