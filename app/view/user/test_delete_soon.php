<?php
use Model\Group;
use Model\UserGroupMap;
use Model\UserImageMap;
use Sm\Core\Abstraction\IoC;
use Sm\Database\PDO\Sql;
use Sm\Database\Schema;
use Sm\Database\SqlModel;

/**
 * @var $user \Model\User
 */
if ($user = IoC::$session->get('user')) {
    $user->findSettingArr();
    var_dump($user);
};

//CREATE A GROUP
/*$company = new Group();
$company->set('name', 'Black Rock Industrial Co TESTING')->set('type', 1)->set('alias','blackrock_test')->set('founder_id', 1);
$company->create();*/


//ADD USERS TO THAT GROUP
/*$company_map = new UserGroupMap();
$company_map->addRow(1,2,1);*/
$qry = Schema::create('group_entity_map', function (Schema $t) {
    $t->create_std();
    $t->id('entity_id');
    $t->id('group_id');
});
Sql::query($qry);