<?php
use Model\Entity;
use Model\Group;
use Model\GroupEntityMap;
use Model\GroupGroupMap;
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
    //var_dump($user);
};

//CREATE A GROUP
/*$company = new Group();
$company->set('name', 'Black Rock Industrial Co TESTING')->set('type', 1)->set('alias','blackrock_test')->set('founder_id', 1);
$company->create();*/


//ADD USERS TO THAT GROUP
/*$company_map = new UserGroupMap();
$company_map->addRow(1,2,1);*/

//CREATE THE ENTITY MAP TABLE
/*$qry = Schema::create('entities', function (Schema $t) {
    $t->create_std();
    $t->string('address');
    $t->string('description');
    $t->string('mission');
    $t->string('url');
});
Sql::query($qry);*/


//CREATE THE ENTITY MAP TABLE
/*$qry = Schema::create('group_entity_map', function (Schema $t) {
    $t->create_std();
    $t->id('entity_id');
    $t->id('group_id');
});
Sql::query($qry);*/

//Create an entity
/*$entity = new Entity();
$entity->set('address', '1001 W Gregory Drive');
$entity->set('description', 'This is a description');
$entity->set('url', 'This is a url');
$entity->create();

$group_entity_map = new GroupEntityMap();
$group_entity_map->addRow(2,1);*/

/*$qry_o = Schema::create('group_group_map', function (Schema $t) {
    $t->create_std();
    $t->id('primary_group_id');
    $t->id('secondary_group_id');
});
Sql::query($qry_o);*/
/*
$g_g_map = new GroupGroupMap();
$g_g_map->addRow(2, 1);

$g = Group::find(2);
$g->findEntity();
$g->findGroups();
var_dump($g);*/

/*$qry_o = Schema::create('transactions', function (Schema $t) {
    $t->create_std();
    $t->integer('donated_amount');
    $t->id('group_id');
});*/

/*$qry_o = Schema::create('group_transaction_map', function (Schema $t) {
    $t->create_std();
    $t->id('transaction_id');
    $t->id('group_id');
});
Sql::query($qry_o);*/
if (!IoC::$session->get('group')) {
    $user = IoC::$session->get('user');
    $user->findGroups();
    if ($groups_arr = $user->getGroups()) {
        $group = array_shift($groups_arr);
        IoC::$session->set('group', $group);
    }
}
$group = IoC::$session->get('group');
$group->findGroups();
var_dump($group->getGroups());