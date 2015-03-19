<?php
/**
 * User: Samuel
 * Date: 1/26/2015
 * Time: 3:29 PM
 */
namespace Model;

use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class UserGroupMap extends \Sm\Core\Abstraction\MapModelAbstraction implements ModelInterface {
    static protected $table_name = 'user_group_map';
    static protected $string_key = '';
    static protected $_maps = ['user_id' => 'Model\User', 'group_id' => 'Model\Group'];
    protected $id = 0;
    protected $user_id = 0;
    protected $group_id = 0;
    protected $role_id;

    public function getRoleId() {
        return $this->role_id;
    }
    static function addRow($user_id, $group_id, $type) {
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($user_id, $group_id, $type) {
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

    /**
     * Find out the permissions of a user in relation to another user
     * todo implement some sort of nosql or object oriented way of doing this kind of check
     */
    public static function getUUAbilities($ug_context_doer, $receiver_ug_context) {
        $permission_array = [           #
            'max_role_change' => false, #The highest role a user can delete
            'min_role_change' => false, #
            'delete' => false           #
        ];
        $doer_role = isset($ug_context_doer['role_id']) ? $ug_context_doer['role_id'] : false;
        $receiver_role = isset($receiver_ug_context['role_id']) ? $receiver_ug_context['role_id'] : false;
        if (!$doer_role || !$receiver_role) {
            return $permission_array;
        }
        if ($doer_role == 1 || ($doer_role >= $receiver_role and $doer_role < 3)) {
            $permission_array['max_role_change'] = $doer_role;
            $permission_array['min_role_change'] = 10;
        }
        return $permission_array;
    }

    public function setRole($role_id) {
        return $this->set('role_id', $role_id);
    }
}
