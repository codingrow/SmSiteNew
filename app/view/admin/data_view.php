<?php
$past_donations = [["name" => "asdf", "date" => "3/1/15", "amount" => 35], ["name" => "bobs burgers", "date" => "2/19/12", "amount" => 75], ["name" => "north korea", "date" => "13/13/13", "amount" => -4]];
?>

<div class="past_donations">
    <table class="past_donations_table">
        <tr>
            <td class="table_title" colspan="3">List of Past Donations</td>
        </tr>
        <tr>
            <td><strong>Charity Name</strong></td>
            <td><strong>Date</strong></td>
            <td><strong>Amount</strong></td>
        </tr>
        <?php foreach ($past_donations as $key => $value) : ?>
            <tr>
                <td><?= $value["name"]; ?></td>
                <td><?= $value["date"]; ?></td>
                <td>$<?= $value["amount"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>