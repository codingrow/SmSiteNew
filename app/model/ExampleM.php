<?php
/**
 * User: Samuel
 * Date: 3/13/2015
 * Time: 8:55 PM
 */

namespace Model;

use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;

class ExampleM extends ModelAbstraction implements ModelInterface{
    static $table_name = 'ExampleM';
    static $string_key = 'example_id';
}