<?php
/**
 * User: Samuel
 * Date: 1/30/2015
 * Time: 4:42 PM
 */

namespace Model;


use Sm\Core\Abstraction\IoC;
use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class Image extends ModelAbstraction implements ModelInterface{
    static protected $table_name = 'images';
    /**
     * @var string
     */
    static protected $string_key = 'server_name';
    protected $id;
    protected $name;
    protected $server_name;
    protected $_url;
    protected $directory;
    protected $caption;
    protected $user_context;

    function getUrl() {
        if (isset($this->_url)) return $this->_url;
        return false;
    }
    function getName(){
        if (isset($this->name)) return $this->name;
        return false;
    }
    function getCaption(){
        if (isset($this->caption)) return $this->caption;
        return false;
    }
    function getImageSize(){
        if(!$this->_url){
            $this->initUrl();
        }
        return getimagesize($this->_url);
    }

    //todo make this into an actual thing?
    public function initUrl() {
//        $directory  = isset($this->directory) ? 'p/img/pic/' . $this->directory . '/' : '';
//        $picture = isset($this->server_name) ? $this->server_name : 'p/img/telephasic/pic05.jpg';
//        $this->_url  = IoC::$uri->url($directory . $picture);
        $this->_url = 'http://ventureosity.com/wp-content/uploads/2014/10/malala-yousafzai-ftr.jpg';
    }

    public static function addImage($name, $server_name, $path, $caption = '') {
        $return_id = SqlModel::query_table(static::$table_name, function (SqlModel $t) use ($name, $server_name, $path, $caption) {
            $t->insert(['name', 'server_name', 'directory', 'caption'], [$name, $server_name, $path, $caption]);
        }, 'id');
        return $return_id;
    }
}