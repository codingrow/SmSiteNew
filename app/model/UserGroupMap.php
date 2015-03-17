<?php
/**
 * User: Samuel
 * Date: 1/26/2015
 * Time: 3:29 PM
 */
namespace Model;

use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class UserGroupMap extends \Sm\Core\Abstraction\MapModelAbstraction implements ModelInterface{
    static protected $table_name    = 'user_group_map';
    static protected $string_key    = '';
    protected $id                   = 0;
    protected $user_id              = 0;
    protected $group_id             = 0;
    protected $role_id;
    protected $_search_from         = '';
    static protected $_maps          =
        [
            'user_id'=>'Model\User',
            'group_id'=>'Model\Group'
        ];

    public function setRole($role_id){
        return $this->set('role_id', $role_id);
    }
    static function addRow($user_id, $group_id, $type){
        return SqlModel::query_table(static::$table_name, function(SqlModel $t) use ($user_id, $group_id, $type){
            $t->insert(['user_id', 'group_id', 'role_id'], [$user_id, $group_id, $type]);
            #todo on duplicate key... (make it so that there is only one active image profile? Do that somewhere else?)
        }, 'id');
    }

    static function delRow($user_id, $group_id) {
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($user_id, $group_id) {
            $t->where('user_id = ' . $user_id . ' AND group_id = ' . $group_id)->delete();
            #todo on duplicate key... (make it so that there is only one active image profile? Do that somewhere else?)
        });
    }

    public static function getUUAbilities($ug_context_doer, $receiver_ug_context) {

    }
}