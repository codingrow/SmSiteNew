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
     * @var array $settings_arr an array of the user's settings
     */
    public $settings_arr = [];
    /**
     * @var array
     */
    public $group_context = [];
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
        $query = "SELECT DISTINCT u.id, u.username, u.first_name, u.last_name
              FROM users u
              INNER JOIN user_user_map
              ON u.id = user_user_map.user_id_child
              INNER JOIN users u2
              ON u2.id = user_user_map.user_id_parent AND u2.id = $id AND user_user_map.status = 1
          UNION
            SELECT u.id, u.username, u.first_name, u.last_name
              FROM
                users u INNER JOIN user_user_map
                ON u.id = user_user_map.user_id_parent
                INNER JOIN users u2
                ON u2.id = user_user_map.user_id_child AND u2.id = $id
          UNION
              SELECT u3.id, u3.username, u3.first_name, u3.last_name
              FROM users u3 , user_setting_map usm
            WHERE (NOT EXISTS (
                SELECT *
                FROM  user_setting_map usm2
                WHERE u3.id = usm2.user_id AND usm2.setting_id = 1
            )) OR (usm.setting_id = 1 AND usm.value <>2 AND u3.id = usm.user_id)
              ";
        return SqlModel::query_table(static::$table_name, $query, 'all');
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

    public function findSettingArr() {
        $map = new UserSettingMap('user', 'setting');

        $settings = $map->map($this->id);
        foreach ($settings as $key => $value) {
            /**
             * @var \Model\Setting $value
             */
            $value->setValue($value->user_context['value']);
            unset($value->user_context);
        }
        $this->settings_arr = $settings;
        return $this;
    }

    public static function make_directories($username) {
        mkdir(USER_PATH.'user/'.$username.'/files/'.'img'   , 0777, true);
        mkdir(USER_PATH.'user/'.$username.'/files/'.'css'   , 0777, true);
        mkdir(USER_PATH.'user/'.$username.'/temp'           , 0777, true);
        mkdir(USER_PATH.'user/'.$username.'/logs'           , 0777, true);
    }
}