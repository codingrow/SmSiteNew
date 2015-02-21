<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 5:01 PM
 */

namespace Model;

use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class GroupTransactionMap extends \Sm\Core\Abstraction\MapModelAbstraction implements ModelInterface {
    static protected $table_name = 'group_transaction_map';
    static protected $string_key = '';
    protected $id = 0;
    protected $user_id = 0;
    protected $group_id = 0;
    protected $_search_from = '';
    static protected $_maps = ['transaction_id' => 'Model\Transaction', 'group_id' => 'Model\Group'];

    static function addRow($group_id, $transaction_id) {
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($group_id, $transaction_id) {
            $t->insert(['group_id', 'transaction_id'], [$group_id, $transaction_id]);
            #todo on duplicate key... (make it so that there is only one active image profile? Do that somewhere else?)
        }, 'id');
    }

}