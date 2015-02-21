<?php
$past_donations = [];
?>

<section class="past_donations">
    <table class="past_donations_table">
        <?php foreach ($past_donations as $key => $value) : ?>
            <tr>
                <td><?= $value["name"]; ?></td>
                <td><?= $value["date"]; ?></td>
                <td><?= $value["amount"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>