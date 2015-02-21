<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 12:54 PM
 */
namespace Model;

use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class GroupEntityMap extends \Sm\Core\Abstraction\MapModelAbstraction implements ModelInterface {
    static protected $table_name = 'group_entity_map';
    static protected $string_key = '';
    protected $id = 0;
    protected $user_id = 0;
    protected $group_id = 0;
    protected $_search_from = '';
    static protected $_maps = ['entity_id' => 'Model\Entity', 'setting_id' => 'Model\Setting'];

    static function addRow($group_id, $entity_id) {
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($group_id, $entity_id) {
            $t->insert(['group_id', 'entity_id'], [$group_id, $entity_id]);
            #todo on duplicate key... (make it so that there is only one active image profile? Do that somewhere else?)
        }, 'id');
    }

}