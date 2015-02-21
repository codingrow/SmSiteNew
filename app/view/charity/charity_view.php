<?php
$charity_info = ["name" => "myCharity", "description" => "We are a company dedicated to the preservation of nature, including trees, animals, bugs, and everything else.", "primary_contact" => "Jane Doe", "url" => "http://google.com", "tax_code" => "12345", "address" => "3400 Penn", "phone_number" => "1234567899"];
?>

<div class="charity_info">
    <h2><a href="<?= $charity_info["url"] ?>"></a><?= $charity_info['name'] ?></h2>

    <div><em><?= $charity_info['description'] ?></em></div>
    <br/>
    Primary Contact: <?= $charity_info["primary_contact"] ?> <br/>
    Website: <a href="<?= $charity_info["url"] ?>">Go to the charity's webpage</a> <br/>
    Tax Code: <?= $charity_info["tax_code"] ?> <br/>
    Address: <?= $charity_info["address"] ?> <br/>
    Phone Number: <?= $charity_info["phone_number"] ?> <br/>

</div>