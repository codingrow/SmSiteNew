<?php
use Sm\Core\Abstraction\IoC;

$employees = [[["username" => "Kneehar", "first_name" => "Nihar", "last_name" => "Sheth", "email" => "niharrsheth@gmail.com"], ["username" => "Kneehar", "first_name" => "Nihar", "last_name" => "Sheth", "email" => "niharrsheth@gmail.com"]]];
/** @var \Model\User $user */
if ($user = IoC::$session->get('user')) {
    $groups_arr = $user->findGroups();

}
?>

<table>
    <?php foreach ($employees as $key => $value): ?>

        <tr>
            <td><?= $value["username"] ?></td>
            <td><?= $value["first_name"] ?></td>
            <td><?= $value[0] ?></td>
            <td><?= $value[0] ?></td>
        </tr>

    <?php endforeach ?>
</table>