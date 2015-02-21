<?php
/**
 * User: Samuel
 * Date: 2/20/2015
 * Time: 10:45 PM
 */

namespace Model;

use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class Setting extends ModelAbstraction implements ModelInterface {
    static $table_name = 'settings';
    static $string_key = 'name';
    protected $setting;

    static function add($user_id, $password, $salt = null) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($user_id, $password) {
            #$t->where('user_id = '.$user_id);
            $t->insert(['password', 'user_id'], [$password, $user_id]);
        }, 'id');
    }
}