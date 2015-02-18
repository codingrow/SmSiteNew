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
}