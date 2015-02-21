<?php
/** @var \Model\Group $charity */
var_dump($charity);
$charity_info = ["name" => "myCharity", "description" => "We are a company dedicated to the preservation of nature, including trees, animals, bugs, and everything else.", "primary_contact" => "Jane Doe", "url" => "http://google.com", "tax_code" => "12345", "address" => "3400 Penn, Washington, D.C.", "phone_number" => "1234567899"];
?>

<div class="charity_info">
    To learn more, direct your browser to <a href="<?= $charity->entity->getUrl() ?>"></a> <br/>
    <?= $charity->entity->getAddress() ?> <br/>
    Or contact <?= $charity->entity->getPrimaryContact() ?> at <?= $charity->entity->getPhoneNumber() ?> <br/>
    Tax Code: <?= $charity_info["tax_code"] ?> <br/>

</div>