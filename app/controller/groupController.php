<?php
/**
 * User: Samuel
 * Date: 2/26/2015
 * Time: 2:24 PM
 */


namespace Controller;

use Model\Group;
use Model\User;
use Sm\Core\Abstraction\IoC;

class groupController extends BaseController {
    public function _add_users() {
        //Requires an associative array of user's IDs and group positions to be posted

    }

    public function view($group = 0) {
        $g = Group::find($group)->findGroups()->findEntity()->findUsers();

        $founder = User::find($g->getFounderId());
        /** @var User $user */
        $user = IoC::$session->get('user');
        $group_users = $g->getUsers();
        $role = 2;
        if ($user != false && array_key_exists($user->getUsername(), $group_users)) {
            $role = $group_users[$user->getUsername()]->getGroupContext()['role_id'];
        }

        $data = ['group' => $g, 'user' => $user, 'founder' => $founder, 'role' => $role, 'group_users' => $group_users];

        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => $group, 'secondary_title' => $g->getDescription()]);
        $view->create('group/view', $data, 'view');
        $view->create('group/view_sidebar', $data, 'sidebar');
        $view->nest_view_named('template', 'sidebar', 'sidebar');
        $view->nest_view_named('template', 'view', 'body');
    }

    public function test_feed() {
        IoC::$response->header('content-type', 'application/json');
        return IoC::$backend->run('feed/test', []);
    }

    public function create() {
        $view = &IoC::$view;
        $this->set_template();
        $view->setViewData(['title' => 'Add A Group', 'secondary_title' => 'Create a group!']);
        $view->create('group/create', [], 'create');
        $view->nest_view_named('template', 'create', 'body');
    }

    public function _html_user($group) {
        $group = Group::find($group)->findGroups()->findEntity()->findUsers();
        /** @var User $user */
        $user = IoC::$session->get('user');
        $view = &IoC::$view;
        return $view->create('group/html_users', ['group' => $group, 'user' => $user])->content;
    }

    public function _add_user() {
        IoC::$response->header('content-type', 'application/json');
        return IoC::$backend->run('group/add_user', $_POST);
    }

    public function _del_user() {
        IoC::$response->header('content-type', 'application/json');
        return IoC::$backend->run('group/remove_user', $_POST);
    }

    public function _members($group = 0) {
        IoC::$response->header('content-type', 'application/json');
        return IoC::$backend->run('group/members', ['group' => $group]);
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