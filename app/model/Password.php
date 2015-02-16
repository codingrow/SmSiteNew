<?php
/**
 * User: Samuel
 * Date: 1/27/2015
 * Time: 10:04 PM
 */

namespace Model;

use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class Password extends ModelAbstraction implements ModelInterface{
    static $table_name = 'passwords';
    static $string_key = 'user_id';
    protected $password;
    static function verify($user_id, $password){
        $res = static::find($user_id, 'user_id');
        if($res){
            if(password_verify($password, $res->password)){
                return true;
            }
        }
        return false;
    }
    static function is_valid($password){
        if(strlen($password) < 6){
            return false;
        }else{
            return true;
        }
    }
    static function add($user_id, $password, $salt = null){
        $password = password_hash($password, PASSWORD_BCRYPT);
        return SqlModel::query_table(static::$table_name, function(SqlModel $t) use($user_id, $password){
            #$t->where('user_id = '.$user_id);
            $t->insert(['password', 'user_id'], [$password, $user_id]);
        }, 'id');
    }
}