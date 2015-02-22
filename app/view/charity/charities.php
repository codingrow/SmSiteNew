<?php
/** @var \Model\Group $group */
/** @var \Model\User $user */
use Sm\Core\Abstraction\IoC;

if (!IoC::$session->get('group')) {
    $user = IoC::$session->get('user');
    $user->findGroups();
    if ($groups_arr = $user->getGroups()) {
        $group = array_shift($groups_arr);
        IoC::$session->set('group', $group);
    }
}

$group = IoC::$session->get('group');
if ($group):
    $group->findGroups();
    $group_array = $group->getGroups();
$charities = [["name" => "KneeChar", "contact" => "Nihar", "amount_donated" => "Sheth"], ["name" => "Fredward", "contact" => "Fred", "amount_donated" => "Edwardson"]];
/** @var \Model\User $user */
if ($user = IoC::$session->get('user')) {
    $groups_arr = $user->findGroups();
}
endif;
?>

<table class="tcc_view_table">
    <?php
    if ($group):?>
    <tr class="table_headers">
        <td>Name</td>
        <td>Conact</td>
        <td>Amount Donated</td>
        <td colspan="2">Actions</td>
    </tr>

        <?php
        foreach ($group_array as $key => $value):
            /** @var \Model\Group $value */

            $value->findEntity();
            ?>
        <tr>
            <td><?= $value->getName() ?></td>
            <td><?php if ($value->entity) {
                    echo $value->entity->getContactName();
                } ?></td>
            <td><?= $value->getName() ?></td>
            <td><a href="<?= MAIN_URL ?>user/charity_view/<?= $value->getAlias() ?>">View</a></td>
            <td><a href="<?= MAIN_URL ?>user/donate/<?= $value->getAlias() ?>">Donate</a></td>
        </tr>

    <?php endforeach ?>
    <?php endif; ?>
</table>
<a href="<?= MAIN_URL ?>manage/add_charity">Add Charity</a>
<br/>
<a href="<?= MAIN_URL ?>user/data_view">View Past Charity Donations</a>