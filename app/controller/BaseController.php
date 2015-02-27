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

    protected function set_template($template_name = 'telephasic_std') {
        $view = &IoC::$view;
        $view->create_template($template_name, 'template');
        $view->set('template');
        return $this;
    }
    function index(){
        $view = &IoC::$view;
        $view->setViewData(['title'=>'Home']);
        if (IoC::$session->get("user") !== false) {
            $this->set_template();

            $view->create('user/home', [], 'home_page');
        } else {
            $this->set_template();

            $view->create('home', [], 'home_page');
            //$view->create('user/home', [], 'home_page');
        }
        $view->nest_view_named('template', 'home_page', 'body');
    }

    public function _file_upload() {
        $result = Backend::run('file_upload', ['files'=>$_FILES]);
        if($result === true){
            #Response::redirect(Link::url('me'));
        }
        return $result;
    }
}