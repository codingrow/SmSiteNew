<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:47 PM
 */
namespace Controller;

use Sm\Core\Abstraction\IoC;

class employeesController extends BaseController {
    public function manage() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'General Test of settings', 'secondary_title' => 'My Profile']);
        $view->create('employees/manage', [], 'manage');
        $view->nest_view_named('template', 'manage', 'body');
    }

    public function add() {
        $sam = $_POST;
        IoC::$filter->std($sam);
        $result = IoC::$backend->run('add_employee', [$_POST]);
        if ($result === true) {
            #Response::redirect(Link::url('me'));
        }
        return $result;
    }

    public function _file_upload() {
        $result = IoC::$backend->run('file_upload', ['files' => $_FILES]);
        if ($result === true) {
            #Response::redirect(Link::url('me'));
        }
        return $result;
    }
}