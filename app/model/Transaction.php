<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 4:59 PM
 */
namespace Model;

use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;
use Sm\Database\SqlModel;

class Transaction extends ModelAbstraction implements ModelInterface {
    static $table_name = 'transactions';
    static $string_key = 'donated_amount';
    protected $donated_amount;

    /**
     * @return mixed
     */
    public function getDonatedAmount() {
        return $this->donated_amount;
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
}