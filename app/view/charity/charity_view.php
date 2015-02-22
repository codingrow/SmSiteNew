<?php
/** @var \Model\Group $charity */
//var_dump($charity);
use Model\GroupTransactionMap;
use Sm\Core\Abstraction\IoC;

$group = IoC::$session->get('group');
$group->findGroups();
$info_arr = [];
if ($company = $group->getGroups()) {
    foreach ($company as $key => $group_dealing_with) {
        $group_name = $group_dealing_with->getName();
        $tmp_map = new GroupTransactionMap('group', 'transaction');
        $donation_array = $tmp_map->map($group_dealing_with->getId());
        if ($donation_array) {
            foreach ($donation_array as $amount => $value) {
                if ($value) {
                    $transaction_date = $value->getCreationDt();
                    $info_arr[] = ['amount' => $amount, 'date' => $transaction_date];
                }
            }

        }
    }
}
var_dump($info_arr);
?>

<?= $charity->getName() ?> is one of the many charities we have donated to or intend to donate to in the future. We admire their goals and commitment to our community. We encourage you to
<a href="<?= $charity->entity->getUrl() ?>">visit their webpage</a> to learn more.<br/><br/>

<table>

</table>


<div class="charity_info">
    You can visit this charity at <?= $charity->entity->getAddress() ?> <br/>
    Or contact &nbsp;&nbsp;&nbsp;&nbsp; <?= $charity->entity->getContactName() ?>
    at <?= $charity->entity->getPhoneNumber() ?> <br/>
    Tax Code: <?= $charity->entity->getTaxCode() ?> <br/>

</div>