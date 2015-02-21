<?php
/**
 * User: Samuel
 * Date: 2/20/2015
 * Time: 10:30 PM
 */
namespace Model;

use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class UserSettingMap extends \Sm\Core\Abstraction\MapModelAbstraction implements ModelInterface {
    static protected $table_name = 'user_setting_map';
    static protected $string_key = '';
    protected $id = 0;
    protected $user_id = 0;
    protected $group_id = 0;
    protected $_search_from = '';
    static protected $_maps = ['user_id' => 'Model\User', 'setting_id' => 'Model\Setting'];

    static function addRow($user_id, $group_id, $type) {
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($user_id, $group_id, $type) {
            $t->insert(['user_id', 'group_id', 'role_id'], [$user_id, $group_id, $type]);
            #todo on duplicate key... (make it so that there is only one active image profile? Do that somewhere else?)
        }, 'id');
    }

}