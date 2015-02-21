<?php
/**
 * User: Samuel
 * Date: 2/21/2015
 * Time: 1:47 PM
 */
namespace Controller;

use Sm\Core\Abstraction\IoC;

class manageController extends BaseController {
    public function manage() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Manage employees', 'secondary_title' => 'My Profile']);
        $view->create('employees/manage', [], 'manage');
        $view->nest_view_named('template', 'manage', 'body');
    }

    public function add_charity() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Add charity', 'secondary_title' => 'Charities']);
        $view->create('charity/add_charity', [], 'Charities');
        $view->nest_view_named('template', 'Charities', 'body');
    }

    public function _add_charity() {
        $result = IoC::$backend->run('add_charity', $_POST);
        if (is_array($result)) {
            IoC::$response->header('content-type', 'application/json');
            return json_encode($result);
        } else {
            return '1';
            #IoC::$response->redirect(IoC::$uri->url('home'));
        }
    }

    public function _donate() {
        $result = IoC::$backend->run('donate', $_POST);
        if (is_array($result)) {
            IoC::$response->header('content-type', 'application/json');
            return json_encode($result);
        } else {
            return '1';
            #IoC::$response->redirect(IoC::$uri->url('home'));
        }
    }

}