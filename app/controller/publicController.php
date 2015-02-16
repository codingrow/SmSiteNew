<?php
/**
 * User: Samuel
 * Date: 1/25/2015
 * Time: 2:25 PM
 */

namespace Controller;

use Sm\Core\Controller;
use Sm\Core\Response;

class publicController  extends Controller{

    public function css($name){
        $path = BASE_PATH.'public/css/'.$name;
        if(file_exists($path)){
            Response::clear_screen();
            Response::header('content-type', 'text/css');
            #var_dump(Response::$headers);
            return file_get_contents($path);
        }else{
            return '';
        }
    }

    public function js($name){
        $name = implode('/', func_get_args());
        $path = BASE_PATH.'public/js/'.$name;
        if(file_exists($path)){
            Response::clear_screen();
            Response::header('Content-type', 'application/js');
            return file_get_contents($path);
        }else{
            return '';
        }
    }

    public function img($name){
        if($name == 'pic'){
            $tmp = func_get_args();
            array_shift($tmp);
            if(isset($tmp[0]) and isset($tmp[1])){
                $domain = $tmp[0].'/'.$tmp[1];
                array_shift($tmp);
                array_shift($tmp);
            }else{
                $domain =  'not_rsesolved';
            }
            $name = implode('/', $tmp);
            $path = USER_PATH.$domain.'/files/img/'.$name;
        }else{
            $name = implode('/', func_get_args());
            $path = BASE_PATH.'public/img/'.$name;
        }
        $file_extension = strtolower(substr(strrchr($name,'.'),1));
        switch( $file_extension ) {
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default:
                $ctype = FALSE;
        }

        if(file_exists($path)){
            Response::clear_screen();
            Response::header('Content-type', $ctype);
            return file_get_contents($path);
        }else{
            return '';
        }
    }

}