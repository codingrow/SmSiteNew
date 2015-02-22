<?php
$result = \Sm\Core\Abstraction\IoC::$backend->run('view_emps');
?>
<table class="tcc_view_table">
    <?php foreach ($result as $key => $value): ?>
        <tr>
            <td><?= $value["name"] ?></td>
            <td><?= $value["height"] ?></td>
            <td><?= $value["gender"] ?></td>
        </tr>
    <?php endforeach ?>
</table>
