<?php
/**
 * User: Samuel
 * Date: 1/20/2015
 * Time: 6:44 PM
 */
namespace Model;

use Sm\Core\Abstraction\IoC;
use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\PDO\Connection;
use Sm\Database\SqlModel;

/**
 * Class User
 * @package Model
 */
class User extends \Sm\Core\Abstraction\ModelAbstraction implements ModelInterface{
    /**
     * @var string
     */
    static protected $table_name = 'users';
    /**
     * @var string
     */
    static protected $string_key = 'username';
    /**
     * @var int
     */
    protected $id           = 0;
    /**
     * @var string
     */
    protected $username     = '';
    /**
     * @var string
     */
    protected $first_name   = '';
    /**
     * @var string
     */
    protected $primary_email = '';

    /**
     * @var string
     */
    protected $last_name    = '';
    /**
     * @var int
     */
    protected $type         = 0;
    /**
     * @var integer
     */
    protected $profile_image_id           = '';
    /**
     * @var Image
     */
    public $image           = '';

    /**
     * @var array $settings an array of the user's settings
     */
    protected $settings = [];
    /**
     * @var array
     */
    public $group_context = [];
    /**
     * @var array
     */
    protected $_available_users_sql = [];
    /** @var Group[] External */
    protected $groups = [];


    public function findProfile() {
        $this->image = Image::find($this->profile_image_id);
        $this->image->initUrl();
        /*
         *$map = new UserImageMap('user', 'image');
         *$map->search_for_image_type(1);
         *$ret = $map->map($this->id);
         */
        return $this;
    }

    /**
     * @todo defaultively cache?
     * @param bool $set
     * @return $this|Image[]|bool
     */
    public function findImages($set = false){
        $map = new UserImageMap('user', 'image');
        $map_result = $map->map($this->id);
        if($set) {
            $this->images = $map_result;
            return $this;
        }else{
            return $map_result;
        }
    }

    public function getProfile() {
        if(isset($this->image))
        return $this->image;
        $this->image = new Image();
        return false;
    }
    /**
     * @param string $search_terms Users to search, possibly to be used with a LIKE query
     * @todo ugly, slow
     * @return mixed
     */
    public function findAvailableUsers($search_terms = '') {
        $id = $this->id;
        $query = "SELECT id, username, first_name, last_name, creation_dt, profile_image_id, primary_email FROM users WHERE id != $id";
        return $this->_available_users_sql = SqlModel::query_table(static::$table_name, $query, 'all');
    }

    /**
     * @return array
     */
    public function getAvailableUsersSql() {
        return $this->_available_users_sql;
    }

    /** Consider making this a static function. It really depends on how this could be used...
     * @todo WyTF did I make this?
     * For now, Its sole purpose is to store an array of the available users' username(s) for someone in the session
     * @param $user_list_receptacle
     */
    public function storeAvailableUserList(&$user_list_receptacle) {
        $findAvailableUsers = $this->findAvailableUsers();
        foreach ($findAvailableUsers as $value) {
            $user_list_receptacle[] = $value['username'];
        }
    }
    /**
     * @return $this
     */
    public function findGroups() {
        $map = new UserGroupMap('user', 'group');
        $this->groups = $map->map($this->id);
        return $this;
    }

    /**
     * @param $username
     * @return bool
     */
    public static function is_valid($username) {
        if(!is_string($username) || is_numeric($username) || trim($username) == '')
            return false;

        return true;
    }

    public function addImage($name, $server_name, $type = SM_IMAGE_PROFILE, $path = null, $caption = '' ) {
        IoC::$filter->file_name($name);
        Connection::start_transaction();
        if($path == null){
            $path = 'user/'.$this->username;
        }
        $id = Image::addImage($name, $server_name, $path, $caption);
        if(is_numeric($id)){
            UserImageMap::addRow($this->id, $id, $type);
        }
        Connection::commit();
        if($type == SM_IMAGE_PROFILE){
            $this->findProfile();
        }
    }
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @return array
     */
    public function getGroupContext() {
        return $this->group_context;
    }

    /**
     * @return Group[]
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * @return int
     */
    public function getProfileImageId() {
        return $this->profile_image_id;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    public function findSettings() {
        $map = new UserSettingMap('user', 'setting');

        $settings = $map->map($this->id);
        foreach ($settings as $key => $value) {
            /**
             * @var \Model\Setting $value
             */
            $value->setValue($value->user_context['value']);
            unset($value->user_context);
        }
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimaryEmail() {
        return $this->primary_email;
    }

    public static function make_directories($username) {
        if(!is_dir( USER_PATH.'user/'.$username.'/files/'.'img'))
            mkdir(  USER_PATH.'user/'.$username.'/files/'.'img'   , 0777, true);
        if(!is_dir( USER_PATH.'user/'.$username.'/files/'.'css'))
            mkdir(  USER_PATH.'user/'.$username.'/files/'.'css'   , 0777, true);
        if(!is_dir( USER_PATH.'user/'.$username.'/temp'))
            mkdir(  USER_PATH.'user/'.$username.'/temp'           , 0777, true);
        if(!is_dir( USER_PATH.'user/'.$username.'/logs'))
            mkdir(  USER_PATH.'user/'.$username.'/logs'           , 0777, true);
    }
}