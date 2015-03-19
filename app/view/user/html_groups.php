<?php
/**
 * User: Samuel
 * Date: 3/18/2015
 * Time: 11:20 PM
 */

use Model\Group;
/** @var Group[] $user_groups */
?>
<?php //var_dump($user_groups)?>
<?php foreach ($user_groups as $value): ?>
    <?php
    $me_class = $value->getFounderId() == $user->getId() ? 'me' : '';
    $role = $value->getUserMapping($user->getUsername())->getRoleId();
    $me_class = $role == 1 ? 'me' : '';
    ?>
    <section class="tile <?= $me_class?> clearfix" data-id="<?= $value->getId() ?>">
        <div class="text clearfix">
            <a href="<?= MAIN_URL ?>group/view/<?= $value->getAlias() ?>" class="clearfix">
                <div class="snippet"><?= $value->getName() ?></div>
            </a>
        </div>
    </section>
<?php endforeach; ?>