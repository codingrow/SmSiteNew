<?php
/**
 * User: Samuel
 * Date: 1/28/2015
 * Time: 11:27 AM
 */

namespace Controller;

use Sm\Core\Abstraction\IoC;
use Sm\Core\Backend;            use Sm\Core\Controller;
use Sm\Core\Response;

class BaseController extends Controller{
    static function get(){
        return new static();
    }

    protected function set_template($template_name = 'std_tcc_2_1') {
        $view = &IoC::$view;
        $view->create_template($template_name, 'template');
        $view->set('template');
        return $this;
    }
    function index(){
        $view = &IoC::$view;
        $this->set_template("std_tcc_main");
        $view->setViewData(['title'=>'Home']);
        if (IoC::$session->get("user")) {
            $view->create('me', [], 'home');
        } else {
            $view->create('home', [], 'home');
        }
        $view->nest_view_named('template', 'home', 'body');
    }

    public function _file_upload() {
        $result = Backend::run('file_upload', ['files'=>$_FILES]);
        if($result === true){
            #Response::redirect(Link::url('me'));
        }
        return $result;
    }
}