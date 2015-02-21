<?php
use Model\User;

if (!$user = \Sm\Core\Abstraction\IoC::$session->get("user")) {
    $user = new User();
}
var_dump($user);
?>

<div class="greeting">
    <h2>Welcome <?= $user->getUsername() ?>!</h2>

</div>