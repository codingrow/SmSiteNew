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
                <?php if (!$user): ?>
                    <a href="<?= MAIN_URL ?>home/">Home</a>
                    <a href="<?= MAIN_URL ?>user/signup/">Sign Up</a>
                    <a href="<?= MAIN_URL ?>user/login/" id="loginButton">Log In</a>
                <?php else: ?>
                    <a href="<?= MAIN_URL ?>home/"> Welcome, <?= $user->getUsername() ?></a>
                    <?php if ($user->getType() == 1): ?>
                        <a href="<?= MAIN_URL ?>employees/manage/">Manage Employees</a>
                        <a href="<?= MAIN_URL ?>charities/manage/">Manage Charities</a>
                    <?php endif; ?>
                    <a href="<?= MAIN_URL ?>logout/" id="logoutButton">Log Out</a>
                <?php endif; ?>

            </nav>

        </div>
    </div>
</header>