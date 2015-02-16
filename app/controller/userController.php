<?php
/**
 * User: Samuel
 * Date: 1/25/2015
 * Time: 11:16 AM
 */

namespace Controller;

use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\Core\Response;

class userController extends BaseController {

    public function view($username) {
        $view = &IoC::$view;
        /** @var User $user */
        $user = IoC::$session->get('user');
        $user = $user ?: new User();
        $available_users = IoC::$session->get('available_user_list');
        if (!$available_users) {
            $user_list = [];
            $user->storeAvailableUserList($user_list);
            IoC::$session->set('available_user_list', $user_list);
            $available_users = $user_list;
        }
        if ($username == 'me' || ($user instanceof User and $user->getUsername() == $username)) {
            return $this->me();
        } elseif (in_array($username, $available_users)) {
            $user = User::find($username);
            $view_variables = ['user' => $user];
            $view_data      = ['title' => $user->getUsername()];
            $this->set_template();
            $view->setViewData($view_data);
            $view->create('user/view', $view_variables, 'view');
            $view->nest_view_named('template', 'view', 'body');
            return null;
        }
        return "Cannot View User";
    }

    public function me() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Me']);
        $view->create('user/home', [], 'me');
        $view->nest_view_named('template', 'me', 'body');
        return null;
    }

    public function signup() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Sign Up']);
        $view->create('user/signup', [], 'signup');
        $view->nest_view_named('template', 'signup', 'body');
    }

    public function logout() {
        IoC::$session->clear();
        IoC::$response->redirect(IoC::$uri->url('home'));
    }

    public function login() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Login']);
        $view->create('user/login', [], 'login');
        $view->nest_view_named('template', 'login', 'body');
    }
    public function _update(){
        $result = IoC::$backend->run('user_update', $_POST);
        return '';
    }
    public function _login() {
        IoC::$filter->std($_POST);
        $result = IoC::$backend->run('login', $_POST);
        if (is_array($result)) {
            IoC::$response->header('content-type', 'application/json');
            return json_encode($result);
        } else {
            /** @var User $user */
            if ($user = IoC::$session->get('user')) {
                $user->findGroups();
                $user->findProfile();
                $user_list = [];
                $user->storeAvailableUserList($user_list);
                IoC::$session->set('available_user_list', $user_list);
            }
            IoC::$response->redirect(IoC::$uri->url('home'));
        }
        return '';
    }
    public function image_feed(){
        Response::header('Content-type', 'application/json');
        return IoC::$backend->run('image_feed');
    }
    public function _create_session(){}
    public function _signup() {
        IoC::$filter->std($_POST);
        $result = IoC::$backend->run('verify_user_signup', $_POST);
        if (is_array($result)) {
            IoC::$response->header('content-type', 'application/json');
            return json_encode($result);
        } else {
            return '1';
            #IoC::$response->redirect(IoC::$uri->url('home'));
        }
        return true;
    }
}