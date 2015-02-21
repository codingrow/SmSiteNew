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
    protected $primary_contact;
    protected $tax_code;
    protected $phone_number;

    /**
     * @return mixed
     */
    public function getPrimaryContact() {
        return $this->primary_contact;
    }

    /**
     * @return mixed
     */
    public function getTaxCode() {
        return $this->tax_code;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber() {
        return $this->phone_number;
    }
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