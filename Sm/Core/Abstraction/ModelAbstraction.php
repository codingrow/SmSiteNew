<?php
/**
 * User: Samuel
 * Date: 1/26/2015
 * Time: 8:37 PM
 */

namespace Sm\Core\Abstraction;


use Sm\Database\SqlModel;

abstract class ModelAbstraction {
    /** @var string name of the table being modeled */
    static protected $table_name;
    /** @var ModelAbstraction[] */
    static protected $_maps = ['user_id' => 'Model\User','group_id'=>'Model\Group', 'group_map'=>'Model\UserGroupMap'];

    /** @var string the primary primary|unique  key ruled by a string */
    static protected $string_key = 'title';
    protected $creation_dt;
    protected $update_dt;
    protected $_changed = [];
    /** @var  int  The numeric primary key of the table */
    protected $id;

    /**
     * @param $v
     * @return static
     */
    static function copy($v) {
        return clone $v;
    }

    /** Insert a record into the table with values corresponding to the properties that were set
     * Set the id of the last inserted record equal to the id of the object
     * @todo use the set properties rather than the set _changed array
     * @see  Model::set
     * @return $this
     */
    public function create() {
        $res = SqlModel::query_table(static::$table_name, function (SqlModel $t) {
            $t->insert(array_keys($this->_changed), array_values($this->_changed));
        }, 'id');
        if ($res) {
            $this->id = intval($res);
        }
        $this->_changed = [];
        return $this;
    }

    static function exists($identifier, $key = 'id') {
        $string_key = $key != 'id' ? $key : static::$string_key;
        $result = SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($identifier, $key, $string_key) {
            if (is_numeric($identifier) && $key == 'id') {
                $column = ":id";
                $where = 'id = ' . $column;
            } else {
                $column = ':' . $string_key;
                $where = $string_key . ' = ' . $column;
            }
            $t->select('id')->bind([$column => $identifier])->where($where);
        });
        return (is_array($result) and (!empty($result)));
    }

    public function get($property) {
        return $this->$property;
    }

    public function getId() {
        return $this->id;
    }

    public static function getStringKey() {
        return static::$string_key;
    }

    static function get_table() {
        return SqlModel::query_table(static::$table_name, 'SELECT * FROM ' . static::$table_name, 'all');
    }

    public function has_been_changed() {
        return !empty($this->_changed);
    }

    /**
     * Initialize object based on an array with keys mirroring object properties.
     * @param array $arr
     * @return $this
     */
    function init(array $arr) {
        foreach ($arr as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    public function getTableName() {
        return static::$table_name;
    }
    function map_find(array $key_order, ModelAbstraction $context_type) {
        $string_key = isset($key_order[0]) ? $key_order[0] . '_id' : false; #key to search
        $key_to_search = $string_key !== false ? $key_order[0] : false;
        $type_to_return = isset($key_order[1]) ? $key_order[1] . '_id' : false; #key to return
        $key_to_return = $type_to_return !== false ? $key_order[1] : false;
        if (!$string_key || !$type_to_return) {
            return [];
        }

        $identifier = $this->id;
        $sql_result = SqlModel::query_table($context_type->getTableName(), function (SqlModel $t) use ($identifier, $string_key) {
            $t->select('*');
            $column = ':' . $string_key;
            $where = $string_key . ' = ' . $column;
            $t->bind([$column => $identifier])->where($where);
        }, 'all');
        if (!is_array($sql_result)) {
            return [];
        }

        $map_return = [];
        $class = static::getMap($type_to_return);
        if(!$class){
            return [];
        }
        foreach ($sql_result as $value) {
            $class_result = $class->find($value[$type_to_return]);
                $class_result->{$key_to_search.'_c'}[$this->getStringKeyProperty()] = $context_type->build()->init($value);
                $map_return[$class_result->getStringKeyProperty()] = $class_result;
        }
        return $map_return;
    }

    /**
     * @param $type
     * @return ModelAbstraction
     */
    static function getMap($type) {
        if (isset(static::$_maps[$type])) {
            return new static::$_maps[$type];
        }
        return false;
    }

    /** Return an instantiated object correlating to the desired record
     * @param int|string $identifier The key to search for. If numeric, search id.
     *                               Else, search the set string identifier
     * @return static
     */
    static function find($identifier, $key = 'id') {
        $string_key = $key != 'id' ? $key : static::$string_key;
        $identifier = (string)$identifier;
        $result = SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($identifier, $key, $string_key) {
            if (is_numeric($identifier) && $key == 'id') {
                $column = ":id";
                $where = 'id = ' . $column;
            } else {
                $column = ':' . $string_key;
                $where = $string_key . ' = ' . $column;
            }
            $t->select('*')->bind([$column => $identifier])->where($where);
        });
        if (is_array($result)) {
            $return = new static();
            $return->init($result);
            return $return;
        } else {
            return new static();
        }
    }

    public static function build() {
        return new static;
    }

    public function setContext($context, $value) {
        $context .= '_context';
        $this->$context = $value;
        return $this;
    }

    public function getStringKeyProperty() {
        $property = static::$string_key;
        return $this->$property;
    }

    function remove() {
        SqlModel::query_table(static::$table_name, function (SqlModel $t) {
            $t->where('id = ' . $this->id)->delete();
        });
        return $this;
    }

    /** Update the record with the $_changed values
     * @see Model::set
     * @return $this
     */
    public function save() {
        SqlModel::query_table(static::$table_name, function (SqlModel $t) {
            $t->update($this->_changed)->where("id = {$this->id}");
        });
        $this->_changed = [];
        return $this;
    }

    /**
     * @param $property array|string object property(ies) to receive the value
     * @param $value    int|string|float Value of the object
     * @return $this
     */
    public function set($property, $value = '') {
        if (is_array($property)) {
            foreach ($property as $name => $value) {
                $this->_changed[$name] = $value;
                $this->$name = $value;
            }
            return $this;
        }
        $this->$property = $value;
        $this->_changed[$property] = $this->$property;
        return $this;
    }

    /** Update the timestamp on a given object
     * @return $this
     */
    public function touch() {
        SqlModel::query_table(static::$table_name, function (SqlModel $t) {
            $t->update(['id' => $this->id])->where("id = {$this->id}");
        });
        return $this;
    }
}