<?php
/** @var \Model\Group $charity */
//var_dump($charity);
$charity_info = ["name" => "myCharity", "description" => "We are a company dedicated to the preservation of nature, including trees, animals, bugs, and everything else.", "primary_contact" => "Jane Doe", "url" => "http://google.com", "tax_code" => "12345", "address" => "3400 Penn, Washington, D.C.", "phone_number" => "1234567899"];
?>

<?= $charity->getName() ?> is one of the many charities we have donated to or intend to donate to in the future. We admire their goals and commitment to our community. We encourage you to
<a href="<?= $charity->entity->getUrl() ?>">visit their webpage</a> to learn more.<br/><br/>

<div class="charity_info">
    You can visit this charity at <?= $charity->entity->getAddress() ?> <br/>
    Or contact them <?= $charity->entity->getContactName() ?> at <?= $charity->entity->getPhoneNumber() ?> <br/>
    Tax Code: <?= $charity_info["tax_code"] ?> <br/>

</div>