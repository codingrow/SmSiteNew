<?php
$nihar = [6, 7, 8, 9];
?>

<select name="hours_clocked" id="hours_clocked">
    <?php
    foreach ($nihar as $value):

        ?>
        <option value="<?= $value ?>"><?= $value ?></option>

    <?php endforeach ?>
</select>