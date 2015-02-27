<?php
/**
 * User: Samuel
 * Date: 2/26/2015
 * Time: 2:24 PM
 */


namespace Controller;

use Model\User;
use Sm\Core\Abstraction\IoC;

class groupController extends BaseController {
    public function _add_users() {
        //Requires an associative array of user's IDs and group positions to be posted

    }

    public function create() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Add A Group', 'secondary_title' => 'Create a group!']);
        $view->create('group/create', [], 'create');
        $view->nest_view_named('template', 'create', 'body');
    }

    public function _create() {
        IoC::$filter->std($_POST);
        /** @var User $user */
        $user = IoC::$session->get('user');
        if (!$user) {
            return false;
        }
        $arr = array_merge($_POST, ['founder_id' => $user->getId()]);
        $result = IoC::$backend->run('group_creation', $arr);
        if (is_array($result)) {
            IoC::$response->header('content-type', 'application/json');
            return json_encode($result);
        } else {


            IoC::$response->redirect(IoC::$uri->url('me'));
        }
        return '';
    }
}