<?php
/**
 * User: Samuel
 * Date: 1/28/2015
 * Time: 11:50 PM
 */

namespace Controller;
use Sm\Core\Abstraction\IoC;

class responseController extends BaseController{

    public function controller($method){
        $args = func_get_args();
        $method = 'code'.$method;
        array_shift($args);
        if (method_exists($this, $method) && is_callable(array($this, $method))){
           return call_user_func_array([new $this, $method], func_get_args());
        }
        return true;
    }

    public function code404($message = '404', $page = null) {
        var_dump(IoC::$route->getRoutes());
        if ($page) {
            $page = '[' . $page . ']';
        }
        $view = &IoC::$view;
        $viewData = ['title' => '404', 'error_message' => 'The Page ' . $page . ' You Requested could not be found!'];
        $view->setViewData($viewData);
        $this->set_template();
        $view->setViewData($viewData);
        $view->create('response/stub', [], 'stub');
        $view->nest_view_named('template', 'stub', 'body');
    }

}