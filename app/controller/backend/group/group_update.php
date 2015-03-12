<?php
/**
 * User: Samuel
 * Date: 3/10/2015
 * Time: 1:35 AM
 */
use Model\Group;
use Sm\Core\Abstraction\IoC;

$func = function ($args) {
    /** @var Model\User $user */
    /** @var Group $group */
    $problem_arr = [];
    $permitted_group_info_update_array = ['name', 'description', 'alias'];
    $group_info = isset($args['group_info']) ? $args['group_info'] : [];
    $group_id = isset($group_info['group_id']) ? $group_info['group_id'] : 0;

    $group = Group::find($group_id);
    $user = IoC::$session->get('user');
    if ($group->getId()) {

        if (isset($group_info['name'])):
            $alias = Group::create_alias($group_info['name'], $user);
            if ($alias !== $group->getAlias()) {
                if (Group::exists($alias, 'alias')) {
                    $problem_arr['name'] = 'Looks like you already have a group with that name...';
                    unset($group_info['name']);
                } else {
//                    $group_info['alias'] = $alias;
                }
            }
        endif;
        foreach ($group_info as $key => $value) {
            if (!in_array($key, $permitted_group_info_update_array) or (!is_string($value) or (($value = trim($value)) == '')) or $value == $group->get($key)) {
                continue;
            }
            $group->set($key, $value);
        }
        if (!empty($problem_arr)) {
            return $problem_arr;
        }
        if (!$group->has_been_changed()) {
            return true;
        }
        $group->save();
    }

    return true;
};