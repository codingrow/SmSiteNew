<?php
var_dump($charity);
$charity_info = ["name" => "myCharity", "description" => "We are a company dedicated to the preservation of nature, including trees, animals, bugs, and everything else.", "primary_contact" => "Jane Doe", "url" => "http://google.com", "tax_code" => "12345", "address" => "3400 Penn, Washington, D.C.", "phone_number" => "1234567899"];
?>

<div class="charity_info">
    <h2><a href="<?= $charity_info["url"] ?>"></a><?= $charity_info['name'] ?></h2>

    <div><em><?= $charity_info['description'] ?></em></div>
    <br/>

    To learn more, direct your browser to <a href="<?= $charity_info["url"] ?>">the charity's webpage</a> <br/>
    Visit this charity at <?= $charity_info["address"] ?> <br/>
    Or contact <?= $charity_info["primary_contact"] ?> at <?= $charity_info["phone_number"] ?> <br/>
    Tax Code: <?= $charity_info["tax_code"] ?> <br/>

</div>