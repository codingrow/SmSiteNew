<?php
/**
 * ::req::PDO|namespace
 * User: Samuel
 * Date: 1/20/2015
 * Time: 12:20 PM
 */

namespace Sm\Database;


use Sm\Database\PDO\Sql;

/**
 * Class Model
 * @package Sm\database
 */
class SqlModel extends Sql{
    /**
     * @var
     */
    protected $table_name;

    /**
     * @param $table_name
     */
    function __construct($table_name = '') {
        $this->table_name = $table_name;
    }

    /**
     * @param string $table_name
     * @return static
     */
    public static function instance($table_name = 'test'){
        return new static($table_name);
    }

    /**
     * @param string $table_name Name of "this" table
     * @param string|callback $query The actual query to be run. In this case, most likely a callback
     * @param string $return
     * @todo ugly, slow
     * @param \PDO   $DBH
     * @return bool
     */
    public static function query_table($table_name, $query, $return = 'row', \PDO $DBH= null) {
        $class = new static($table_name);
        $class->set_dbh($DBH);
        $qry = null;
        if(is_callable($query)) {
            $query($class);
            $class->_qry_arr['where_qry'] = isset($class->_qry_arr['where_qry']) ? $class->_qry_arr['where_qry'] : '';
            $class->_qry_arr['from_qry'] = isset($class->_qry_arr['from_qry']) ? $class->_qry_arr['from_qry'] : '';
            if (isset($class->_qry_arr['sel_qry'])) {
                $qry = $class->_qry_arr['sel_qry'] . $class->_qry_arr['from_qry'] . $class->_qry_arr['where_qry'];
            } elseif (isset($class->_qry_arr['update_qry'])) {
                $qry = $class->_qry_arr['update_qry'] . $class->_qry_arr['where_qry'];
            } elseif (isset($class->_qry_arr['insert_qry'])) {
                $on_duplicate = isset($class->_qry_arr['on_duplicate']) ? $class->_qry_arr['on_duplicate'] : '';
                $qry = $class->_qry_arr['insert_qry'] . $class->_qry_arr['where_qry'] . $on_duplicate;
            } elseif (isset($class->_qry_arr['delete_qry'])) {
                $qry = $class->_qry_arr['delete_qry'] . $class->_qry_arr['where_qry'];
            }else{
                $qry = $class->_qry;
            }
        }else{
            $qry = $query;
        }
        $qry .= ";\n";
        try {
            $class->_sth = $class->_DBH->prepare($qry);
        } catch (\PDOException $e) {
            echo $e->getMessage();
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

    public static function make(\PDO $DBH, $query) {
        $class = new static();
        $class->set_dbh($DBH);
        try {
            $class->_sth = $class->_DBH->prepare($query);
        } catch (\PDOException $e) {
            return false;
        }
        return $class;
    }

    public function run($return) {
        if (isset($this->_bind)) {
            foreach ($this->_bind as $key => $value) {
                $this->_sth->bindParam($key, $value);
            }
        }
        try {
            $this->_sth->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $this->_return($return);
    }
    /**
     * Add a 'FROM' clause to the query
     * @param string $table_name the name of the table in question.
     *                           The parameter is only here to maintain consistency with the method set in database\sql
     *                           and should not be used in the model context.
     * @return $this
     */
    public function from($table_name = null){
        if($table_name == null) $table_name = $this->table_name;
        parent::from($table_name);
        return $this;
    }

    /** Select specified columns (func_get_args style)
     * @param $columns, ...
     * @return $this
     */
    public function select($columns){
        if(!$this->getQryArrItem('from_qry')){
                $this->from();
        }
        $columns = is_array($columns) ? $columns : (array) func_get_args();
        parent::select($columns);
        return $this;
    }

    /**
     * @param array $update
     * @param null  $table_name
     * @return $this
     */
    public function update(array $update, $table_name = null){
        parent::update($update, $this->table_name);
        return $this;
    }

    public function on_duplicate($what) {
        $this->_qry_arr['on_duplicate'] = 'ON DUPLICATE KEY UPDATE ';
        return $this;
    }
    /**
     * @param null $t_name
     * @return $this
     */
    public function clear_table($t_name = null){
        parent::clear_table($this->table_name);
        return $this;
    }

    /**
     * @param null $table_name
     * @return $this
     */
    public function delete($table_name = null){
        parent::delete($this->table_name);
        if(!$this->getQryArrItem('where_qry')){
            $this->where('1 = 0');
        }
        return $this;
    }

    /**
     * @param $insert
     * @param $value_arr
     * @return $this
     */
    public function insert($insert, $value_arr){
        $this->setTables($this->table_name);
        parent::insert($insert, $value_arr);
        return $this;
    }
}