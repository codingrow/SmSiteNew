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

    public function _available_users_feed() {
        Response::header('Content-type', 'application/json');
        return IoC::$backend->run('feed/available_users_feed');
    }

    public function _create_group() {
        return IoC::$backend->run('group_creation', $_POST);
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
                $user->findAvailableUsers();
                $user->findSettings();
                $user->findProfile();
            }
            IoC::$response->redirect(IoC::$uri->url('home'));
        }
        return '';
    }

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

    public function _update() {
        IoC::$response->header('content-type', 'application/json');
        return $result = IoC::$backend->run('user/user_update', ['user_info' => $_POST]);
    }

    public function data_view($charity_alias = 2) {
        $charity = Group::find($charity_alias);
        if ($charity) {
            $view = &IoC::$view;
            $this->set_template();
            $view->setViewData(['title' => 'View current data information', 'secondary_title' => 'My Profile']);
            $view->create('admin/data_view', [], 'data_view');
            $view->nest_view_named('template', 'data_view', 'body');
            return null;
        }
    }

    public function gen_test() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'General Test of settings', 'secondary_title' => 'My Profile']);
        $view->create('user/test_delete_soon', [], 'view');
        $view->nest_view_named('template', 'view', 'body');
        return null;
    }

    public function login() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Login']);
        $view->create('user/login', [], 'login');
        $view->nest_view_named('template', 'login', 'body');
    }

    public function logout() {
        IoC::$session->clear();
        IoC::$response->redirect(IoC::$uri->url('home'));
    }

    public function signup() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Sign Up']);
        $view->create('user/signup', [], 'signup');
        $view->nest_view_named('template', 'signup', 'body');
    }

    public function update() {
        $user = IoC::$session->get('user');
        if (!$user) {
            IoC::$response->redirect(IoC::$uri->url('user/login'));
        }

        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Update Account Info']);
        $view->create('user/update', ['user' => $user], 'update');
        $view->nest_view_named('template', 'update', 'body');
    }

    public function view($username) {
        $view = &IoC::$view;
        /** @var User $user */
        $user = IoC::$session->get('user');
        $user = $user ?: new User();
        if (empty($available_users = $user->getAvailableUsersSql())) {
            $user->findAvailableUsers();
        }
        if ($username == 'me' || ($user instanceof User and $user->getUsername() == $username)) {
            return $this->me();
        }
        $found = false;
        foreach ($available_users as $user_arr) {
            if (in_array($username, $user_arr)) {
                $found = true;
                break;
            };
        }

        if ($found) {
            $view_user = User::find($username);
            $view_variables = ['view_user' => $view_user];
            $view_data = ['title' => $view_user->getUsername()];
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
        if (!$user = \Sm\Core\Abstraction\IoC::$session->get("user")) {
            IoC::$response->redirect(IoC::$uri->url('user/login'));
        }
        $view_1 = $view->create('modules/poll', [], 'poll');
        $view->setViewData(['title' => 'Welcome, ' . $user->getUsername(), 'secondary_title' => 'My Profile', '{{nest_sidebar}}' => $view_1->get_content()]);
        $view->create('user/home', [], 'me');
        $view->nest_view_named('template', 'me', 'body');
        return null;
    }
}