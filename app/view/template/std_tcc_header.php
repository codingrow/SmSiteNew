<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,400italic' rel='stylesheet' type='text/css'>

<?php
use \Model\User;

/** @var User $user */
$user = \Sm\Core\Abstraction\IoC::$session->get('user');
?>

<header id="header" class="container">
    <div class="row">
        <div class="12u">

            <!-- Logo -->
            <h1><a href="#" id="logo">Blackrock Charity Services</a></h1>

            <!-- Nav -->
            <nav id="nav">
                <a href="<?= MAIN_URL ?>home/">Home</a>
                <!-- <a href="twocolumn2.html">Two Column #2</a> -->
                <?php if (!$user): ?>
                    <a href="<?= MAIN_URL ?>user/signup/">Sign Up</a>
                    <a href="<?= MAIN_URL ?>user/login/" id="loginButton">Log In</a>
                <?php else: ?>
                    <a href="#"> Welcome, <?= $user->getUsername() ?></a>
                    <a href="<?= MAIN_URL ?>logout/" id="logoutButton">Log Out</a>
                <?php endif; ?>

            </nav>

        </div>
    </div>
</header>