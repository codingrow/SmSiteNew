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
    protected $groups;
    //todo make this protected
    /** @var  Entity */
    public $entity;
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

    /**
     * @return mixed
     */
    public function getGroups() {
        return $this->groups;
    }



    /** Set the $this->users variable to be an array of User objects
     * @return $this
     */
    public function findUsers() {
        $map = new UserGroupMap('group', 'user');
        $this->users = $map->map($this->id);
        return $this;
    }

    /**
     * @return User[]
     */
    public function getUsers() {
        return $this->users;
    }
    
    /** Set the $this->users variable to be an array of User objects
     * @return $this
     */
    public function findEntity() {
        $map = new GroupEntityMap('group', 'entity');
        $sam = $map->map($this->id);
        $this->entity = array_shift($sam);
        return $this;
    }

    /** Set the $this->users variable to be an array of User objects
     * @return $this
     */
    public function findGroups() {
        $map = new GroupGroupMap('secondary_group', 'primary_group');
        $sam = $map->map($this->id);
        $this->groups = $sam;
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

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreationDt() {
        return $this->creation_dt;
    }

    /**
     * @return mixed
     */
    public function getUpdateDt() {
        return $this->update_dt;
    }

    /**
     * @return int
     */
    public function getFounderId() {
        return $this->founder_id;
    }


}