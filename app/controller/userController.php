<?php
/**
 * User: Samuel
 * Date: 1/25/2015
 * Time: 11:16 AM
 */

namespace Controller;

use Model\Group;
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

    public function _charity_vote() {
        IoC::$filter->std($_POST);
        $result = IoC::$backend->run('vote_charity', [$_POST]);
        if (is_array($result)) {
            IoC::$response->header('content-type', 'application/json');
            return json_encode($result);
        } else {
            return '1';
            #IoC::$response->redirect(IoC::$uri->url('home'));
        }
    }
    public function me() {
        $view = &IoC::$view;
        $this->set_template();
        if (!$user = \Sm\Core\Abstraction\IoC::$session->get("user")) {
            IoC::$response->redirect(IoC::$uri->url('login'));
        }
        $view_1 = $view->create('modules/poll', [], 'poll');
        $view->setViewData(['title' => 'Welcome, ' . $user->getUsername(), 'secondary_title' => 'My Profile', '{{nest_sidebar}}' => $view_1->get_content()]);
        $view->create('user/home', [], 'me');
        $view->nest_view_named('template', 'me', 'body');
        $view->nest_view_named('template', 'poll', 'sidebar');
        return null;
    }

    public function charity_view($charity_alias = 2) {
        $charity = Group::find($charity_alias);
        if ($charity) {
            $charity->findEntity();
            $view = &IoC::$view;
            $this->set_template();
            $view->setViewData(['title' => $charity->getName(), 'secondary_title' => $charity->entity->getDescription()]);
            $view->create('charity/charity_view', ['charity' => $charity], 'charity_view');
            $view->nest_view_named('template', 'charity_view', 'body');
        }
    }

    public function charities() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Charity List', 'secondary_title' => 'Charities']);
        $view->create('charity/charities', [], 'Charities');
        $view->nest_view_named('template', 'Charities', 'body');
    }

    public function gen_test() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'General Test of settings', 'secondary_title' => 'My Profile']);
        $view->create('user/test_delete_soon', [], 'view');
        $view->nest_view_named('template', 'view', 'body');
        return null;
    }

    public function data_view() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'View current data information', 'secondary_title' => 'My Profile']);
        $view->create('admin/data_view', [], 'data_view');
        $view->nest_view_named('template', 'data_view', 'body');
        return null;
    }


    public function _admin_view() {
        IoC::$filter->std($_POST);
        $result = IoC::$backend->run('view_emps');
        if (is_array($result)) {
            IoC::$response->header('content-type', 'application/json');
            return json_encode($result);
        } else {
            return '1';
            #IoC::$response->redirect(IoC::$uri->url('home'));
        }
    }
    public function admin_view() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'View employees']);
        $view->create('user/admin_view', [], 'group');
        $view->nest_view_named('template', 'group', 'body');
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