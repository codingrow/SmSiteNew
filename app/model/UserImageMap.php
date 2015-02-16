<?php
/**
 * User: Samuel
 * Date: 1/30/2015
 * Time: 4:44 PM
 */

namespace Model;

use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class UserImageMap extends \Sm\Core\Abstraction\MapModelAbstraction implements ModelInterface{
    static protected $table_name    = 'user_image_map';
    static protected $string_key    = '';
    protected $id                   = 0;
    protected $user_id              = 0;
    protected $image_id             = 0;
    protected $_search_from         = '';
    protected $_and_where     = null;
    static protected $_maps          =
        [
            'user_id'=>'Model\User',
            'image_id'=>'Model\Image'
        ];
    function search_for_image_type($image_type){
        $this->and_where('image_type_id = '.$image_type);
    }
    function and_where($and_where){
        $this->_and_where = $and_where;
    }
    function map($identifier, $light = true, $mutate_sql = null){
        $mutate_sql = function(SqlModel &$t)use($identifier){
            $string_key     = $this->_key_to_search.'_id';
            $column = ':' . $string_key;
            $where = $string_key . ' = ' . $column;
            if(isset($this->_and_where)){
                $where .= ' AND '.$this->_and_where;
            }
            $t->bind([$column => $identifier])->where($where);
        };
        return parent::map($identifier, $light, $mutate_sql);
    }
    static function addRow($user_id, $image_id, $type){
        return SqlModel::query_table(static::$table_name, function(SqlModel $t) use ($user_id, $image_id, $type){
            $t->insert(['user_id', 'image_id', 'image_type_id'], [$user_id, $image_id, $type]);
            #todo on duplicate key... (make it so that there is only one active image profile? Do that somewhere else?)
        }, 'id');
    }
}