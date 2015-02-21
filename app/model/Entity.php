<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 12:58 PM
 */
namespace Model;

use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class Entity extends ModelAbstraction implements ModelInterface {
    static $table_name = 'entities';
    static $string_key = 'url';
    protected $address;
    protected $mission;
    protected $description;
    protected $url;
    public $group_context;

    /**
     * @return mixed
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getMission() {
        return $this->mission;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
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

    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }

    public function setSetting($value) {
        $this->_setting = $value;
        return $this;
    }
}