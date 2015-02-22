<?php
use Sm\Core\Abstraction\IoC;

$employees = [["username" => "Kneehar", "first_name" => "Nihar", "last_name" => "Sheth", "email" => "niharrsheth@gmail.com"], ["username" => "Fredward", "first_name" => "Fred", "last_name" => "Edwardson", "email" => "fredward@gmail.com"]];
/** @var \Model\User $user */
if ($user = IoC::$session->get('user')) {
    $groups_arr = $user->findGroups();

}
?>

<table class="tcc_view_table">
    <tr class="table_headers">
        <td>Username</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Email</td>
    </tr>
    <?php foreach ($employees as $key => $value): ?>

        <tr>
            <td><?= $value["username"] ?></td>
            <td><?= $value["first_name"] ?></td>
            <td><?= $value["last_name"] ?></td>
            <td><?= $value["email"] ?></td>
        </tr>

    <?php endforeach ?>
</table>
<a href="#">Add Employee</a>
