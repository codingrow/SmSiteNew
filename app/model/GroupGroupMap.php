<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:20 PM
 */

namespace Model;

use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class GroupGroupMap extends \Sm\Core\Abstraction\MapModelAbstraction implements ModelInterface {
    static protected $table_name = 'group_group_map';
    static protected $string_key = '';
    protected $id = 0;
    protected $user_id = 0;
    protected $group_id = 0;
    static protected $_maps = ['primary_group_id' => 'Model\Group', 'secondary_group_id' => 'Model\Group'];

    static function addRow($primary_group_id, $secondary_group_id) {
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($primary_group_id, $secondary_group_id) {
            $t->insert(['primary_group_id', 'secondary_group_id'], [$primary_group_id, $secondary_group_id]);
        }, 'id');
    }

}