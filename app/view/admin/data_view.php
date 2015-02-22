<?php
use Sm\Core\Abstraction\IoC;

$group = IoC::$session->get('group');
$group->findGroups();

$past_donations = [];
$hackarr = [];
if ($company = $group->getGroups()) {
    foreach ($company as $key => $group_dealing_with) {

        $group_name = $group_dealing_with->getName();
        $tmp_map = new \Model\GroupTransactionMap('group', 'transaction');
        $donation_array = $tmp_map->map($group_dealing_with->getId());
        if ($donation_array) {
            foreach ($donation_array as $donate => $value) {
                if ($value) {
                    $transaction_date = $value->getCreationDt();
                    $past_donations[] = ['name' => $group_name, 'date' => $transaction_date, 'amount' => $donate];
                }
            }
        }
        //var_dump($donation_array);
    }
}
//$past_donations = [["name" => "asdf", "date" => "3/1/15", "amount" => 35], ["name" => "bobs burgers", "date" => "2/19/12", "amount" => 75], ["name" => "north korea", "date" => "13/13/13", "amount" => 4]];
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages': ['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('number', 'Amount');

        <?php foreach ($past_donations as $key=>$value): ?>
        data.addRows([
            ['<?=$value["name"] ?>', <?=$value["amount"] ?>],
        ]);
        <?php endforeach ?>

        // Set chart options
        var options = {
            'title': 'Charity donations',
            'width': 800,
            'height': 800
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>


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

<div id="chart_div"></div>