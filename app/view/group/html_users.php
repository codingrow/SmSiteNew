<?php
/**
 * User: Samuel
 * Date: 3/4/2015
 * Time: 6:26 PM
 */
use Model\Group;
use Model\Role;
use Model\User;

/** @var Group $group */
/** @var User $user */
/** @var User[] $group_users */

$uig_context = $uig_id = $me_class = $uig_username = $uig_first_name = $uig_last_name = $uig_role = null;
?>

<?php foreach($group_users as $user_in_group):
    $uig_context = $user_in_group->getGroupMapping($group->getAlias());
    $uig_id = $user_in_group->getId();
    $me_class = $uig_id == $user->getId() ? 'me' : '';
    $uig_username = $user_in_group->getUsername();
    $uig_first_name = $user_in_group->getFirstName();
    $uig_last_name = $user_in_group->getLastName();
    $uig_role = $uig_context->getRoleId();
    ?>
    <section class="tile <?= $me_class ?> clearfix" data-id="<?= $uig_id ?>">
        <div class="text clearfix">
            <a href="<?= MAIN_URL . 'user/view/' . $uig_username ?>" class="clearfix">
                <div class="snippet">
                    <?= $uig_username ?>
                </div>
                <div class="snippet">
                    <em><?= $uig_first_name . ' ' . $uig_last_name ?></em>
                </div>
                <div class="snippet">
                    <em><?= Role::getCorrelating($uig_role) ?></em>
                </div>
            </a>
            <?php if ($role == 1): ?>
                <div class="edit edit-user clearfix">
                    <div class="editing-select">
                        Select
                    </div>
                    <div class="editing-edit">
                        Edit
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endforeach; ?>