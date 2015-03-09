<?php
/**
 * User: Samuel
 * Date: 2/17/2015
 * Time: 11:49 PM
 */
namespace Controller;

use Sm\Core\Abstraction\IoC;

class testController extends BaseController {
    public function maps() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Maps Test']);
        $view->create('test/google_maps', [], 'maps');
        $view->nest_view_named('template', 'maps', 'body');
    }

    public function file() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'File']);
        $view->create('test/basic_file', [], 'file');
        $view->nest_view_named('template', 'file', 'body');
    }

    public function dump() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'File']);
        $view->create('test/dump', [], 'dump');
        $view->nest_view_named('template', 'dump', 'body');
    }

    public function _file_upload() {
        $result = IoC::$backend->run('file_upload', ['files' => $_FILES]);
        if ($result === true) {
            #Response::redirect(Link::url('me'));
        }
        return $result;
    }
}