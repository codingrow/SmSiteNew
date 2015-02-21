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
        $view->setViewData(['title' => 'General Test of settings', 'secondary_title' => 'My Profile']);
        $view->create('employees/manage', [], 'manage');
        $view->nest_view_named('template', 'manage', 'body');
    }

    public function add_charity() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'General Test of settings', 'secondary_title' => 'Charities']);
        $view->create('charity/charities', [], 'Charities');
        $view->nest_view_named('template', 'Charities', 'body');
    }

    public function _add_charity() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'General Test of settings', 'secondary_title' => 'My Profile']);
        $view->create('employees/manage', [], 'manage');
        $view->nest_view_named('template', 'manage', 'body');
    }

}