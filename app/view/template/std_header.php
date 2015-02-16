<?php
use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\html\HTML;

/** @var User $user */
$user = IoC::$session->get('user');

if($user and $user->getProfile() and $url = $user->getProfile()->getUrl()){
    $image_url = $url;
}else{
    $image_url = 'http://localhost/SmSiteNew/p/img/S2Low.png';
}
?>
<div id="socialMedia" class="">
    <ul id="">
        <li>
            <a href="http://www.facebook.com">
                <?= HTML::icon('facebook.png', 'Facebook'); ?>
            </a>
        </li>
        <li>
            <a href="http://www.twitter.com">
                <?= HTML::icon('twitter.png', 'Twitter'); ?>
            </a>
        </li>
        <li>
            <a href="http://www.flickr.com">
                <?= HTML::icon('flickr.png', 'Flickr'); ?>
            </a>
        </li>
    </ul>
</div>
<header class="main ">
    <div class="main header wrap">
        <div id="menu" class="container_30">
            <h1> <a href="<?= MAIN_URL ?>"> Steve Buscemi's Due Admiration </a> </h1>
            <menu class="subset">
                <ul id="accountButtons" class="account">
                    <?php if(!$user):?>
                        <li class="signup"><a href="<?= MAIN_URL ?>user/signup/">Sign Up</a></li>
                        <li class="login"><a href="<?= MAIN_URL ?>user/login/" id="loginButton" >Log In</a></li>
                    <?php else:?>
                        <li class="uAlias"><a href="<?= MAIN_URL ?>me/"><img width="35px" src="<?=$image_url?>">Welcome, <span class="uAlias"><?=$user->getUsername()?></span></a></li>
                        <li class="logout"><a href="<?= MAIN_URL ?>logout/" id="logoutButton" >Log Out</a></li>
                    <?php endif;?>
                </ul>
            </menu>
        </div>
    </div>
    <div class="main nav wrap">
        <div id="nav" class="container_30" >
            <nav id="mainNav" class="header-nav">
                <ul>
                    <li><?= HTML::anchor('home', 'HOME', 'The Portal to the site')?></li>
                    <li><?= HTML::anchor('read', 'READ', 'Read up on your favorite topics')?></li>
                    <li><?= HTML::anchor('post', 'POST', 'Add to the community')?></li>
                    <li><?= HTML::anchor('blog', 'BLOG', 'Interact with our blog!')?></li>
                    <li class="has_a_dropdown">
                        <a href="<?= MAIN_URL ?>me/" title="Manage Account Details">YOU</a>
                    </li>
                </ul>
            </nav>
            <form id="searchform" action="" method="get" class="search">
                <p id="searchbar">
                    <label for="search">Search: </label><input type="text" name="search" value="" id="search" placeholder="Search" class="rounded search" />
                    <button type="submit"><img src="<?=MAIN_URL?>p/img/searchIcon.png"/></button>
                </p>
            </form>
        </div>
    </div>
</header>
<style>
    .mainHeader{
        height: 150px;
        background: url(<?= MAIN_URL.'p/img/Spread7Banner.png'?>);
        background-size: cover;
        padding-bottom: 20px;
    }
    .testNotReal{
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