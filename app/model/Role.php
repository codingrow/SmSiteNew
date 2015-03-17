<?php
/**
 * User: Samuel
 * Date: 3/13/2015
 * Time: 8:56 PM
 */
namespace Model;

use Sm\Core\Abstraction\ModelAbstraction;
use Sm\Core\Abstraction\ModelInterface;

class Role extends ModelAbstraction implements ModelInterface{
    static $table_name = 'roles';
    static $string_key = 'role_id';

    public static function getCorrelating($id = 1){
        $response = 'Other';
        switch($id){
            case 1:
                $response = 'Top Banana';
                break;
            case 2:
                $response = 'Admin';
                break;
            case 3:
                $response = 'Limited Admin';
                break;
            case 4:
                $response = 'Gilded Member';
                break;
            case 5:
                $response = 'Gilded Member';
                break;
        }
        return $response;
    }

    public static function getAllTypes() {
        $types = [
            1=>'Owner',
            2=>'Admin',
            3=>'Limited Admin',
            4=>'Gilded Member',
            5=>'Member'
        ];
        return $types;
    }
}