<?php
/**
 * User: Samuel
 * Date: 3/4/2015
 * Time: 6:26 PM
 */
use Model\Group;
use Model\User;

/** @var Group $group */
/** @var User $user */

$founder = User::find($group->getFounderId());
$group_users = $group->getUsers();
$role = 2;
if ($user != false && array_key_exists($user->getUsername(), $group_users)) {
    $role = $group_users[$user->getUsername()]->getGroupContext()['role_id'];
}
?>
<?php foreach ($group_users as $user_in_group): ?>
    <section class="user-tile clearfix" data-id="<?= $user_in_group->getId() ?>">
        <a href="<?= MAIN_URL ?>user/view/<?= $user_in_group->getUsername() ?>" class="clearfix">
            <div class="tile-holder clearfix">
                <img src=" <?= ($user_in_group->findProfile()->getProfile()->getUrl()) ?>"/>
            </div>
            <div class="text clearfix">
                <?= $user_in_group->getFirstName() ?>&nbsp;<?= $user_in_group->getLastName() ?>
                <br/>
                <em><?= $user_in_group->getUsername() ?></em>
                <?php if ($role == 1): ?>
                    <div class="edit edit-user delete clearfix">
                        Delete
                    </div>
                <?php endif; ?>
            </div>
        </a>
    </section>
<?php endforeach; ?>