<?php
/**
 * User: Samuel
 * Date: 1/25/2015
 * Time: 8:48 PM
 */

namespace Model;


use Sm\Core\Abstraction\IoC;
use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;

/**
 * Class Group
 * @package Model
 */
class Group extends ModelAbstraction implements ModelInterface {
    /**
     * @var string
     */
    static protected $table_name = 'groups';
    /**
     * @var string
     */
    static protected $string_key = 'alias';
    /** @var User[] External */
    public $users = [];
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
    protected $user_c;
    /**
     * @var int
     */
    protected $founder_id = 0;
    protected $groups;
    //todo make this protected

    /**
     *
     */
    public function __construct() { }

    /** Remove a user from the groups
     * @return $this
     */
    public function addUser($user_id, $role_id) {
        $map = new UserGroupMap('group', 'user');
        $map->addRow($user_id, $this->id, $role_id);
    }

    public static function create_alias($name, User $user) {
        //todo replace with regexp
        $group_alias = str_replace(',', '', $name);
        $group_alias .= '_' . $user->getId();
        IoC::$filter->std($group_alias);
        IoC::$filter->url($group_alias);
        return ($group_alias);
    }

    public function findUsers() {
        $this->users = $this->map_find(['group', 'user'], new UserGroupMap());
        return $this;
    }
    /**
     * @param string $group
     * @return \Model\UserGroupMap
     */
    public function getUserMapping($group) {
        return isset($this->user_c[$group]) ? $this->user_c[$group] : new UserGroupMap();
    }
    /**
     * @return string
     */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * @param string $user
     * @return \Model\Group
     */
    public function getContextualUser($user) {
        return isset($this->user_c[$user]) ? $this->user_c[$user] : new User();
    }

    /**
     * @return mixed
     */
    public function getCreationDt() {
        return $this->creation_dt;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getFounderId() {
        return $this->founder_id;
    }

    /**
     * @return mixed
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUpdateDt() {
        return $this->update_dt;
    }

    /**
     * @return User[]
     */
    public function getUsers() {
        return $this->users;
    }

    /** Remove a user from the groups
     * @return $this
     */
    public function removeUser($user_id) {
        $map = new UserGroupMap('group', 'user');
        $map->removeRow($user_id);
        return $this;
    }

}