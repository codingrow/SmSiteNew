<?php
/**
 * ::echo:: method|new_connection
 * ::echo:: method|static_connection
 * ::req::mysql
 * ::req::PDO
 *
 * User: Samuel
 * Date: 1/19/2015
 * Time: 3:34 PM
 */

namespace Sm\Database\PDO;


/**
 * Class Connection
 * @package Sm\Database
 * @author Sam Washington
 * @todo reduce dependency with PDO
 * @todo add log
 */
class Connection {
    /** @var string */
    private $host       ;     private $username   ;     private $database   ;     private $password   ;

    static private $dbHost        = 'localhost';
    static private $dbUser        = 'root';
    static private $dbDatabase    = 'smsitenew';
    static private $dbPassword    = '';

    static private $dbConnection = false;
    private $connection = false;
    function __construct(){
        $this->host = self::$dbHost;
        $this->password = self::$dbPassword;
        $this->username = self::$dbUser;
        $this->database = self::$dbDatabase;
    }

    /**
     * @param string $host
     */
    public function setHost($host) {
        $this->host = $host;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @param string $database
     */
    public function setDatabase($database) {
        $this->database = $database;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**Return a static connection to the database after creating one if it is not already there
     * @return bool|\PDO
     */
    static function static_connection(){
        if(self::$dbConnection == false){
            try{
                $dsn = "mysql:host=".self::$dbHost.";dbname=".self::$dbDatabase;
                self::$dbConnection = new \PDO($dsn, self::$dbUser, self::$dbPassword);
                self::$dbConnection ->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch (\PDOException $e){
                echo $e->getMessage();
            }
        }
        return self::$dbConnection;
    }

    /**
     * @param callable $closure To be used with the setters of the host, username, password, and databse name in case
     *                          there is ever a different database used
     * @return bool|\PDO
     */
    static function new_connection(callable $closure = null){
        $item = new Connection();
        if($closure != null){
            $closure($item);
        }
        try{
            $dsn = "mysql:host=".$item->host.";dbname=".$item->database;
            $item->connection = new \PDO($dsn, $item->username, $item->password);
            $item->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        }catch (\PDOException $e){
            echo $e->getMessage();
        }
        return $item->connection;
    }

    /**
     * @param \PDO $DBH optional databse handle referenced to begin the transaction
     */
    static function start_transaction(\PDO $DBH = null){
        $DBH = ($DBH!= null) ? $DBH : Connection::static_connection();
        $DBH->beginTransaction();
    }

    /** Rolls back the transaction
     * @param \PDO $DBH optional databse handle referenced to begin the transaction
     */
    static function rollback(\PDO $DBH = null){
        $DBH = ($DBH!= null) ? $DBH : Connection::static_connection();
        $DBH->rollBack();
    }

    /** Commits the transaction to a given Database hamdle defaulting to the static connection
     * @param \PDO $DBH optional databse handle referenced to begin the transaction
     */
    static function commit(\PDO $DBH = null){
        $DBH = ($DBH!= null) ? $DBH : Connection::static_connection();
        $DBH->commit();
    }
}