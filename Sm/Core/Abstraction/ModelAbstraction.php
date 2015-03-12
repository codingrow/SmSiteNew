<?php
/**
 * User: Samuel
 * Date: 1/26/2015
 * Time: 8:37 PM
 */

namespace Sm\Core\Abstraction;


use Sm\Database\SqlModel;

abstract class ModelAbstraction {
    /** @var string name of the table being modeled     */
    static protected $table_name;

    protected $creation_dt;
    protected $update_dt;
    protected $_changed = [];
    /** @var  int  The numeric primary key of the table*/
    protected $id;
    /** @var string the primary primary|unique  key ruled by a string     */
    static protected $string_key = 'title';
    /**
     * Initialize object based on an array with keys mirroring object properties.
     * @param array $arr
     * @return $this
     */
    function init(array $arr){
        foreach ($arr as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    public function setContext($context, $value) {
        $context .= '_context';
        $this->$context = $value;
        return $this;
    }

    /**
     * @param $v
     * @return static
     */
    static function copy($v){
        return clone $v;
    }
    static function exists($identifier, $key = 'id'){
        $string_key = $key != 'id' ? $key : static::$string_key;
        $result =  SqlModel::query_table(static::$table_name, function(SqlModel $t) use ($identifier,$key,  $string_key){
            if(is_numeric($identifier) && $key == 'id'){
                $column = ":id";
                $where = 'id = '.$column;
            }else {
                $column = ':'.$string_key;
                $where = $string_key.' = '.$column;
            }
            $t->select('id')->bind([$column=>$identifier])->where($where);
        });
        return(is_array($result) and (!empty($result)));
    }
    /** Return an instantiated object correlating to the desired record
     * @param int|string $identifier The key to search for. If numeric, search id.
     *                               Else, search the set string identifier
     * @return static
     */
    static function find($identifier, $key = 'id'){
        $string_key = $key != 'id' ? $key : static::$string_key;
        $result =  SqlModel::query_table(static::$table_name, function(SqlModel $t) use ($identifier,$key,  $string_key){
            if(is_numeric($identifier) && $key == 'id'){
                $column = ":id";
                $where = 'id = '.$column;
            }else {
                $column = ':'.$string_key;
                $where = $string_key.' = '.$column;
            }
            $t->select('*')->bind([$column=>$identifier])->where($where);
        });
        if(is_array($result)){
            $return = new static();
            $return->init($result);
            return $return;
        }else{
            return new static();
        }
    }
    /**
     * @param $property array|string object property(ies) to receive the value
     * @param $value    int|string|float Value of the object
     * @return $this
     */
    public function set($property, $value = ''){
        if(is_array($property)){
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

    public function get($property) {
        return $this->$property;
    }

    public function has_been_changed() {
        return !empty($this->_changed);
    }
    public static function getStringKey() {
        return static::$string_key;
    }
    public function getStringKeyProperty() {
        $property = static::$string_key;
        return $this->$property;
    }
    public function getId(){
        return $this->id;
    }
    /** Update the timestamp on a given object
     * @return $this
     */
    public function touch() {
        SqlModel::query_table(static::$table_name, function(SqlModel $t){
            $t->update(['id'=>$this->id])->where("id = {$this->id}");
        });
        return $this;
    }

    /** Update the record with the $_changed values
     * @see Model::set
     * @return $this
     */
    public function save() {
        SqlModel::query_table(static::$table_name, function(SqlModel $t){
            $t->update($this->_changed)->where("id = {$this->id}");
        });
        $this->_changed = [];
        return $this;
    }

    /** Insert a record into the table with values corresponding to the properties that were set
     * Set the id of the last inserted record equal to the id of the object
     * @todo use the set properties rather than the set _changed array
     * @see Model::set
     * @return $this
     */
    public function create(){
        $res = SqlModel::query_table(static::$table_name, function(SqlModel $t){
            $t->insert(array_keys($this->_changed), array_values($this->_changed));
        }, 'id');
        if($res){
            $this->id = intval($res);
        }
        $this->_changed = [];
        return $this;
    }
    function remove(){
        SqlModel::query_table(static::$table_name, function(SqlModel $t){
            $t->where('id = '.$this->id)->delete();
        });
        return $this;
    }
    static function get_table(){
        return SqlModel::query_table(static::$table_name, 'SELECT * FROM '.static::$table_name, 'all');
    }
}