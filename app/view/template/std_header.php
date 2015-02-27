<?php
use Model\User;
use Sm\Core\Abstraction\IoC;

/** @var User $user */
$user = IoC::$session->get('user');

if ($user and $user->getProfile() and $url = $user->getProfile()->getUrl()) {
    $image_url = $url;
} else {
    $image_url = 'http://localhost/SmSiteNew/p/img/S2Low.png';
}
?>

<!--    <button type="submit"><img src="--><? //=MAIN_URL?><!--p/img/searchIcon.png"/></button>  -->

<!-- Header -->
<div id="header-wrapper">
    <div id="header" class="row container">
        <!-- Logo -->
        <h1 id="logo"><a href="<?= IoC::$uri->url('') ?>">{{site_title}}</a></h1>
        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li>
                    <a class="item" href="">Dropdown</a>
                    <ul>
                        <li><a href="#">Lorem ipsum dolor</a></li>
                        <li><a href="#">Magna phasellus</a></li>
                        <li><a href="#">Etiam dolore nisl</a></li>
                        <li>
                            <a href="">Phasellus consequat</a>
                            <ul>
                                <li><a href="#">Lorem ipsum dolor</a></li>
                                <li><a href="#">Phasellus consequat</a></li>
                                <li><a href="#">Magna phasellus</a></li>
                                <li><a href="#">Etiam dolore nisl</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Veroeros feugiat</a></li>
                    </ul>
                </li>
                <?php if (!$user instanceof User): ?>
                    <li class="item"><a href="<?= MAIN_URL ?>user/signup/">Sign Up</a></li>
                    <li class="item"><a href="<?= MAIN_URL ?>user/login/" id="loginButton">Log In</a></li>
                <?php else: ?>
                    <li class="item uAlias"><a href="<?= MAIN_URL ?>me/">Welcome, <span class="uAlias"><?= $user->getUsername() ?></span></a></li>
                    <li class="item logout"><a href="<?= MAIN_URL ?>logout/" id="logoutButton">Log Out</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<style>
    .mainHeader {
        height: 150px;
        background: url(<?= MAIN_URL.'p/img/Spread7Banner.png'?>);
        background-size: cover;
        padding-bottom: 20px;
    }

    .testNotReal {
        height: auto;
        background: #a4afb7;
        background-size: cover;
    }

    .testNotReal .testTitle {
        display: inline;
        float: left;
        width: auto;
        /*background: rgba(255, 255, 255, 0.6);*/
    }
</style>