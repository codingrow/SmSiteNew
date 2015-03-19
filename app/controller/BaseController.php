<?php
/**
 * User: Samuel
 * Date: 1/28/2015
 * Time: 11:27 AM
 */

namespace Controller;

use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\Core\Backend;
use Sm\Core\Controller;

class BaseController extends Controller {
    static function get() {
        return new static();
    }

    public function dump_post() {

    }

    protected function set_template($template_name = 'telephasic_std') {
        $view = &IoC::$view;
        $view->create_template($template_name, 'template');
        $view->set('template');
        return $this;
    }

    function index() {
        $view = &IoC::$view;
        $view->setViewData(['title' => 'Home']);
        $data = [];

        if ($user_id = \Sm\Core\Abstraction\IoC::$session->get("user_id")) {
            $user = User::find($user_id);
            $this->set_template();
            $data['user'] = $user;
            $view->create('user/home', $data, 'home_page');
        } else {
            $this->set_template();

            $view->create('home', [], 'home_page');
            //$view->create('user/home', [], 'home_page');
        }
        $view->nest_view_named('template', 'home_page', 'body');
    }

    public function _file_upload() {
        $result = Backend::run('file_upload', ['files' => $_FILES]);
        if ($result === true) {
            #Response::redirect(Link::url('me'));
        }
        return $result;
    }
}