<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 5:09 PM
 */

use Model\Group;
use Model\GroupTransactionMap;
use Model\Transaction;

$func = function ($args) {
    $amount = isset($args['amount']) ? $args['amount'] : null;
    $charity_alias = isset($args['name']) ? $args['name'] : null;
    /** @var Group $charity */
    if (!$charity = Group::find($charity_alias)) {
        return false;
    }
    $id = $charity->getId();
    $transaction = new Transaction();
    $transaction->set('donated_amount', $amount)->create();
    if (!$trans_id = $transaction->getId()) {
        return false;
    }
    $map = new GroupTransactionMap();
    $map->addRow($id, $trans_id);

    return true;
};