<?php
use Sm\Core\Abstraction\IoC;

$employees = [["name" => "KneeChar", "contact" => "Nihar", "amount_donated" => "Sheth"], ["name" => "Fredward", "contact" => "Fred", "amount_donated" => "Edwardson"]];
/** @var \Model\User $user */
if ($user = IoC::$session->get('user')) {
    $groups_arr = $user->findGroups();

}
?>

<table class="tcc_view_table">
    <tr class="table_headers">
        <td>Name</td>
        <td>Conact</td>
        <td>Amount Donated</td>
        <td colspan="2">Actions</td>
    </tr>
    <?php foreach ($employees as $key => $value): ?>

        <tr>
            <td><?= $value["name"] ?></td>
            <td><?= $value["contact"] ?></td>
            <td><?= $value["amount_donated"] ?></td>
            <td><a href="">View</a></td>
            <td><a href="">Edit</a></td>
        </tr>

    <?php endforeach ?>
</table>
<button>Add Charity</button
