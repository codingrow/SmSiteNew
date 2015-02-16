<?php
/**
 * User: Samuel
 * Date: 1/25/2015
 * Time: 8:48 PM
 */

namespace Model;


use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;

/**
 * Class Group
 * @package Model
 */
class Group extends ModelAbstraction implements ModelInterface{
    /**
     * @var string
     */
    static protected $table_name = 'groups' ;
    /**
     * @var string
     */
    static protected $string_key = 'alias'  ;
    /**
     * @var int
     */
    protected $id = 0;
    /**
     * @var string
     */
    protected $name = '';
    /**
     * @var string
     */
    protected $description = '';
    /**
     * @var string
     */
    protected $alias = '';
    /**
     * @var int
     */
    protected $founder_id = 0;
    /** @var User[] External */
    public $users = [];
    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    /**
     *
     */
    public function __construct() {    }

    /** Set the $this->users variable to be an array of User objects
     * @return $this
     */
    public function findUsers() {
        $map = new UserGroupMap('group', 'user');
        $this->users = $map->map($this->id);
        return $this;
    }

    /** Remove a user from the groups
     * @return $this
     */
    public function removeUser($user_id) {
        $map = new UserGroupMap('group', 'user');
        $map->removeRow($user_id);
        return $this;
    }
    /** Remove a user from the groups
     * @return $this
     */
    public function addUser($user_id, $role_id) {
        $map = new UserGroupMap('group', 'user');
        $map->addRow($user_id, $this->id, $role_id);
    }

}