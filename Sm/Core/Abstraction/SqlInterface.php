<?php
/**
 * User: Samuel
 * Date: 2/5/2015
 * Time: 11:17 AM
 */

namespace Sm\Core\Abstraction;


/**
 * Interface SqlInterface
 * @package Sm\Core\Abstraction
 */
interface SqlInterface {
    /**
     * Generate and/or execute a specified query
     * @param $query callable|string, function to build query or query to run
     * @param $return_type string type to return. Row, All, num_row, lastInsertId, others as they come
     * @param $DBH mixed a handle to the database to be used. Useful if there are going to be multiple connections to
     *                   the database used, such as if there are multiple wueries being run independently of each other
     * @return mixed    normally returns an array, can return false or an integer id
     */
    static function query($query, $return_type, $DBH);

    /** An update clause is to be added to the query
     * @param array $update
     * @param       $table_name
     * @return mixed
     */
    public function update(array $update, $table_name);

    /**
     * specify the return type of the query. (what you expect back).
     * @param string $type
     * @return mixed
     */
    public function _return($type = 'all');

    /**
     * Adds an insert clause to the query
     * @param $insert_columns
     * @param $value_columns
     * @return mixed
     */
    public function insert($insert_columns, $value_columns);

    /**
     * Adds an 'into' clause to the query. Used for "Insert Into..." may be later used for select into?
     * @param null $table
     * @return mixed
     */
    public function into($table = null);

    /**
     * Adds a select clause to the query.
     * @param $columns
     * @return mixed
     */
    public function select($columns);

    /**
     * Adds a from clause to the query. Useful for the Select or Delete queries.
     * @param $table_name
     * @return mixed
     */
    public function from($table_name);

    /**
     * Adds a where clause to the query.
     * @param $var
     * @return mixed
     */
    public function where( $var);

    /**
     * Delete clause for query
     * @param $table_name
     * @return mixed
     */
    public function delete($table_name);

    /**
     * Erase the data from a specified table
     * @param $table_name
     * @return mixed
     */
    public function clear_table($table_name);

    /**
     * @param $tables
     * @return mixed
     */
    public function setTables($tables);

    /**
     * @param $DBH
     * @return mixed
     */
    public function set_dbh($DBH);

    /**
     * For bound parameters, specifies the parameters to bind. These are bound by reference.
     * @param $to_bind
     * @return mixed
     */
    public function ref_bind($to_bind);

    /**
     * For bound parameters, specifies the parameters to bind. Not bound by reference
     * @param $to_bind
     * @return mixed
     */
    public function bind($to_bind);
}