<?php
/**
 *      ::req::mysql
 *      ::sam:: method|id
 *      ::sam:: method|std
 *
 * User: Samuel
 * Date: 1/19/2015
 * Time: 12:12 PM
 */

namespace Sm\Database;


class Schema {
    /** @var string */
    protected $qry  = "";
    protected $type = "add";
    public function getQry(){
        return $this->qry;
    }

    /** ::~sam:: */
    function primary_id(){
        $this->integer('id', 11)->unsigned()->not_null()->primary()->auto_increment();
        return $this;
    }
    function id($name){
        $this->integer($name, 11)->unsigned();
        return $this;
    }
    function primary_tiny_id(){
        $this->tiny_int('id', 3)->unsigned()->not_null()->primary()->auto_increment();
        return $this;
    }
    function tiny_id($name){
        $this->tiny_int($name, 3)->unsigned();

        return $this;
    }
    function create_std(){
        $this->primary_id();
        $this->datetime('creation_dt')->not_null()->default_value("now")->comment("Datetime of record creation");
        $this->datetime('update_dt')->on_update()->comment("Datetime of record update");
    }
    /** ::sam~:: */

    function default_value($default = 1){
        if($default == 'now') $default = 'CURRENT_TIMESTAMP';
        elseif($default == 'null') $default = 'NULL';
        else $default = "'{$default}'";
        $this->qry .= " DEFAULT {$default}";
        return $this;
    }

    function comment($comment = ""){
        $this->qry .= " COMMENT '{$comment}'";
        return $this;
    }

    function auto_increment($start = null){
        if($start == null){
            $this->qry .= " AUTO_INCREMENT";
        }
        return $this;
    }

    function not_null(){
        $this->qry .= " NOT NULL";
        return $this;
    }

    function primary($columns = null){
        if($columns != null){
            if($this->qry != "")  $this->qry .= ", \n";
            $this->qry .= "PRIMARY KEY";
            $columns = is_array($columns) ? $columns : (array) func_get_args();
            $this->qry .= "(";
            $qry = "";
            foreach ($columns as $loop_column) {
                $qry .= " " . $loop_column . ",";
            }
            $this->qry  .= trim(rtrim($qry, ",")).")";
        }else{
            $this->qry .= " PRIMARY KEY";
        }
        return $this;
    }
    function datetime($name){
        if($this->qry != "" && $this->type != "append")  $this->qry .= ", \n";

        $this->qry .= $name . " DATETIME";
        return $this;
    }

    function unsigned(){
        $this->qry .= " UNSIGNED";
        return $this;
    }

    function on_update(){
        $this->qry .= " ON UPDATE CURRENT_TIMESTAMP";
        return $this;
    }

    function unique($columns = null){
        $this->qry .= " UNIQUE";
        if($columns != null){
            $columns = is_array($columns) ? $columns : (array) func_get_args();
                $this->qry .= "(";
            $qry = "";
                foreach ($columns as $loop_column) {
                    $qry .= " " . $loop_column . ",";
                }
                $this->qry  .= trim(rtrim($qry, ",")).")";
        }
        return $this;
    }

    function check(){

    }
    function column($column_name = ''){
        $this->qry .= " COLUMN {$column_name}";
        return $this;
    }
    function add(){
        if($this->qry != "")  $this->qry .= ", \n";

        $this->qry .= "ADD ";
        return $this;
    }

    function drop(){
        if($this->qry != "")  $this->qry .= ", \n";

        $this->qry .= "DROP ";
        return $this;
    }

    function constraint($name){
        if($this->qry != "")  $this->qry .= ", \n";

        $this->qry .= "CONSTRAINT {$name} ";
        return $this;
    }

    function integer($name, $length  = 11){
        if($this->qry != "" && $this->type != "append")  $this->qry .= ", \n";

        $this->qry .= $name . " INT({$length}) ";
        return $this;
    }

    function tiny_int($name, $length  = 11){
        if($this->qry != "" && $this->type != "append")  $this->qry .= ", \n";

        $this->qry .= $name . " TINYINT({$length}) ";
        return $this;
    }

    function string($name, $length = 50, $std = true){
        if($this->qry != "" && $this->type != "append")  $this->qry .= ", \n";

        $this->qry .= $name . " VARCHAR({$length}) ";

        return $this;
    }
    static function alter($table_name, $closure){
        $class = new static;
        $class->type = "append";
        $closure($class);
        $qry = "ALTER TABLE {$table_name}  \n".$class->getQry() ." \n";
        return $qry;
    }
    static function drop_table($table_name){
        $qry = "DROP TABLE {$table_name}";
        return $qry;
    }
    static function create($table_name,  callable $closure){
        $class = new static;
        $closure($class);
        $qry = "CREATE TABLE IF NOT EXISTS {$table_name} ( \n".$class->getQry() ." \n)";
        return $qry;
    }
}