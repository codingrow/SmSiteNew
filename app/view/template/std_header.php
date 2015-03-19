<?php
use Model\User;
use Sm\Core\Abstraction\IoC;

/** @var User $user */
$user = User::find(IoC::$session->get('user_id'));
if ($user and $user->getProfile() and $url = $user->getProfile()->getUrl()) {
    $image_url = $url;
} else {
    $image_url = RESOURCE_URL.'img/S2Low.png';
}
?>
<!-- Header -->
<div id="header-wrapper">
    <div id="header" class="row container">
        <!-- Logo -->
        <h1 id="logo"><a href="<?= IoC::$uri->url('') ?>">{{site_title}}</a></h1>
        <!-- Nav -->
        <nav id="nav">
            <ul>
                <?php if (!$user->getId()): ?>
                    <li class="item"><a href="<?= MAIN_URL ?>user/signup/">Sign Up</a></li>
                    <li class="item"><a href="<?= MAIN_URL ?>user/login/" id="loginButton">Log In</a></li>
                <?php else: ?>
                    <li>
                        <a class="item" href="">Links</a>
                    </li>
                    <li class="item uAlias"><a href="<?= MAIN_URL ?>me/">Welcome, <span class="uAlias"><?= $user->getUsername() ?></span></a>
                        <ul>
                            <li><a href="<?= MAIN_URL . 'me/#my_groups' ?>">Groups</a>
                                <ul>
                                    <?php $group_arr = $user->getGroups() ?>
                                    <?php foreach ($group_arr as $group => $group_obj) : ?>
                                        <li><a href="<?= MAIN_URL . 'group/view/' . $group ?>"><?= $group_obj->getName() ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
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