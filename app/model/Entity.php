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

    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }

    public function setSetting($value) {
        $this->_setting = $value;
        return $this;
    }
}