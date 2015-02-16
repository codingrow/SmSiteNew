<?php
/**
 * User: Samuel
 * Date: 1/26/2015
 * Time: 3:57 PM
 */

namespace Sm\Core\Abstraction;



use Sm\Database\SqlModel;

abstract class MapModelAbstraction extends ModelAbstraction{
    /** @var ModelAbstraction */
    static protected $_maps =
        [
            'user_id'=>'Model\User'
        ];
    protected $_key_to_search   = 'user';
    protected $_key_to_return   = 'group';

    function __construct($_key_to_search = '', $_key_to_return = '') {
        if($_key_to_search){
            $this->_key_to_search = $_key_to_search;
        }
        if($_key_to_search){
            $this->_key_to_return = $_key_to_return;
        }
    }
    /**
     * @param $type
     * @return ModelAbstraction
     */
    static function getMap($type){
        if(isset(static::$_maps[$type]))
            return new static::$_maps[$type];
        return false;
    }
    /**
     * @param int|string $identifier
     * @param            $table
     */
    function map($identifier, $light = false, $mutate_sql = null){
        $string_key     = $this->_key_to_search.'_id';
        $type_to_return = $this->_key_to_return.'_id';
        $result =  SqlModel::query_table(static::$table_name, function(SqlModel $t) use ($identifier, $string_key, $mutate_sql){
            $t->select('*');
            if(!is_callable($mutate_sql)) {
                $column = ':' . $string_key;
                $where = $string_key . ' = ' . $column;
                $t->bind([$column => $identifier])->where($where);
            }else{
                $mutate_sql($t);
            }
        }, 'all');
        if(is_array($result)){
            $return = [];
            if($class = static::getMap($type_to_return)){
                foreach ($result as $value) {
                    $class_result = $class->find($value[$type_to_return]);
                    if($class_result){
                        if(!$light) $class_result->setContext($this->_key_to_search, $value);
                        $return[$class_result->getStringKeyProperty()] = $class_result;
                    }else{
                        $return[]=$value;
                    }
                }
            }else{
                $return = $result;
            }
            return $return;
        }else{
            return false;
        }
    }
    function removeRow($id){
        return SqlModel::query_table(static::$table_name, function(SqlModel $t)use ($id){
            $t->delete()->where($this->_key_to_return.'_id'.' = '.$id);
        });
    }
}