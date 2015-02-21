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
    protected $_value;
    protected $name;
    public $user_context;

    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }

    public function setSetting($value) {
        $this->_setting = $value;
        return $this;
    }

    static function add($setting_name) {
        return SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($setting_name) {
            $t->insert(['name'], [$setting_name]);
        }, 'id');
    }
}