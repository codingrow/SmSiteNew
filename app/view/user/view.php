<?php
/**
 * User: Samuel
 * Date: 1/30/2015
 * Time: 12:56 PM
 */
use Model\User;

/** @var $view_user User */
?>

<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <section>
        <?php
        $view_user->findProfile();
        var_dump($view_user);
        ?>
    </section>
</article>
