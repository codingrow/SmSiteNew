<?php
/**
 * User: Samuel
 * Date: 1/19/2015
 * Time: 4:34 PM
 */

namespace Sm\Database\PDO;


use Sm\Core\Abstraction\SqlInterface;

class Sql implements SqlInterface{
    protected $_qry;
    /** @var \PDO $_DBH*/
    protected $_DBH;
    /** @var \PDOStatement $_sth*/
    protected $_sth;
    /** @var    array An array containing all of the query information present for the specific query.
     *  @todo   make it so this makes more sense. Maybe a Qry class?
     */
    protected $_qry_arr;
    protected $_bind_reference, $_bind;
    static $backtick = false;

    public static function query($callback, $return = 'row', $DBH = null){
        $class = new static;
        $class->set_dbh($DBH);
        $qry = null;
        if(is_callable($callback)) {
            $callback($class);
            $class->_qry_arr['where_qry'] = isset($class->_qry_arr['where_qry']) ? $class->_qry_arr['where_qry'] : '';
            $class->_qry_arr['from_qry'] = isset($class->_qry_arr['from_qry']) ? $class->_qry_arr['from_qry'] : '';
            if (isset($class->_qry_arr['sel_qry'])) {
                $qry = $class->_qry_arr['sel_qry'] . $class->_qry_arr['from_qry'] . $class->_qry_arr['where_qry'];
            } elseif (isset($class->_qry_arr['update_qry'])) {
                $qry = $class->_qry_arr['update_qry'] . $class->_qry_arr['where_qry'];
            } elseif (isset($class->_qry_arr['insert_qry'])) {
                $qry = $class->_qry_arr['insert_qry'] . $class->_qry_arr['where_qry'];
            } elseif (isset($class->_qry_arr['delete_qry'])) {
                $qry = $class->_qry_arr['delete_qry'] . $class->_qry_arr['where_qry'];
            }else{
                $qry = $class->_qry;
            }
        }else{
            $qry = $callback;
        }
        $qry .= ";\n";
        try {
            $class->_sth = $class->_DBH->prepare($qry);
        } catch (\PDOException $e) {
            return false;
        }
        if(isset($class->_bind)) {
            foreach ($class->_bind as $key => $value) {
                $class->_sth->bindValue($key, $value);
            }
        }
        try {
            $class->_sth->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        } catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
        return $class->_return($return);
    }
    public function update(array $update, $table_name){
        $qry = " UPDATE {$table_name} SET ";
        foreach ($update as $key => $value) {
            $this->_bind[":".$key] = $value;
            $qry .= "{$key} = :{$key}";
            end($update);
            if($key !== key($update)){
                $qry .= ", ";
            }
        }
        $this->_qry_arr['update_qry'] = $qry;
        $this->where("1 = 0");
        return $this;
    }
    public function _return($type = 'all'){
        if($this->_sth != false){
            try {
                switch ($type) {
                    case 'num':
                        return $this->_sth->fetchAll(\PDO::FETCH_NUM);
                        break;
                    case 'row':
                        return $this->_sth->fetch(\PDO::FETCH_ASSOC);
                        break;
                    case 'num_row':
                        return $this->_sth->fetch(\PDO::FETCH_NUM);
                        break;
                    case 'id':
                        return $this->_DBH->lastInsertId();
                        break;
                    default:
                    case 'all':
                        return $this->_sth->fetchAll(\PDO::FETCH_ASSOC);
                        break;
                }
            }catch (\PDOException $e){

            }
        }
        return false;
    }
    public function insert($insert_columns, $value_columns){
        $table = isset($this->_qry_arr['tables']) ? $this->_qry_arr['tables'] : null;
        if($table == null){
            return $this;
        }
        if(is_string($value_columns)) $value_columns = [[$value_columns]];
        elseif(is_array($value_columns) && !empty($value_columns) &&  !is_array($value_columns[0])) $value_columns = [$value_columns];
        $value_size = count($value_columns);
        if(is_string($insert_columns)) $insert_columns = [$insert_columns];
        $columns = '(' ; $values = 'VALUES';
        $qry = 'INSERT INTO '. $table . " ";
        foreach ($insert_columns as $key => $value) {
            $columns .= $value;
            end($insert_columns);
            if($value_size === 1){
                $this->_bind[":".$value] =  $value_columns[0][$key];
                $value_columns[0][$key] = ":".$value;
            }
            if($key !== key($insert_columns)){
                $columns .= ", ";
            }else{
                $columns .= ")\n";
            }
        }
        foreach ($value_columns as $key => $value) {
            $values .= " (";
            foreach ($value as $k=>$v  ) {
                $values .= $v;
                end($value);
                if ($k !== key($value)) {
                    $values .= ", ";
                } else {
                    $values .= ")";

                }
            }
            end($value_columns);
            if($key !== key($value_columns)){
                $values .= ", \n";
            }
        }
        $qry .= $columns . $values;
        $this->_qry_arr['insert_qry'] = $qry;
        return $this;
    }
    public function into($table = null){
        $this->_qry_arr['tables'] = isset($table) ? $table : isset($this->_qry_arr['tables']) ? $this->_qry_arr['tables'] : null;
        return $this;
    }
    public function select($columns){
        $columns = is_array($columns) ? $columns : (array) func_get_args();
        $qry = "SELECT ";
        foreach ($columns as $name => $alias) {
            if(is_numeric($name)){
                $column_name = $alias;
                $alias = '';
            }else{$column_name = $name;}
            if(static::$backtick == TRUE && $column_name != "*"){
                $column_name = trim($column_name);
                $column_name = "`{$column_name}`";
            }
            $qry .= "{$column_name}";
            if($alias != '' && !is_numeric($alias)){
                $qry .= " AS {$alias}";
            }
            end($columns);
            if($name != key($columns)){
                $qry .= ", ";
            }
        }
        $this->_qry_arr['sel_qry'] = $qry;
        return $this;
    }
    public function from($table_name){
        $tmp_from = ' FROM ';
        $table_name = is_array($table_name) ? $table_name : (array) func_get_args();
        foreach ($table_name as $key => $value) {
            if(is_numeric($key)){
                if($value == '') continue;
                $tmp_from .= $value;
            }elseif(is_string($key) && is_string($value)){
                $tmp_from .= $key." AS ".$value;
            }
            $tmp_from .= ', ';
        }
        $tmp_from = rtrim($tmp_from, ', ');
        $this->_qry_arr['from_qry'] = $tmp_from;
        return $this;
    }
    public function where( $var){
        $qry = " WHERE {$var}";
        $this->_qry_arr['where_qry'] = $qry;
        return $this;
    }
    public function delete($table_name){
        $this->_qry_arr['delete_qry'] = "DELETE FROM {$table_name} ";
        return ;
    }
    public function clear_table($table_name){
        $qry = "DELETE FROM {$table_name}; ALTER TABLE {$table_name} AUTO_INCREMENT=0";
        $this->_qry = $qry;
        return $this;
    }
    public function setTables($tables){        $this->_qry_arr['tables'] = $tables;    }
    public function set_dbh($_DBH = null){
        $this->_DBH = ($_DBH!= null) ? $_DBH : Connection::static_connection();
    }

    /** Retrieve an item from the query array
     * @param string $item
     * @return string|bool The item if exists, false otherwise.
     */
    public function getQryArrItem($item = '') {
        if(isset($this->_qry_arr[$item])) return $this->_qry_arr[$item];
        return false;
    }
    public function ref_bind($to_bind){
        $to_bind = (array)$to_bind;
        foreach ($to_bind as $key => $value) {
            $this->_bind_reference[$key]= $value;
        }
        return $this;
    }
    public function bind($to_bind){
        $to_bind = (array)$to_bind;
        foreach ($to_bind as $key => $value) {
            $this->_bind[$key]= $value;
        }
        return $this;
    }
}