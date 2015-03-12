<?php
/**
 * User: Samuel
 * Date: 3/10/2015
 * Time: 12:30 AM
 */
use Model\User;

/**
 * @var User $user
 */
?>


<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <article>
        <form class="full-children" action="<?= MAIN_URL ?>user/_update" method="post">
            <label for="first_name">
                First Name:
                <input id="first_name" name="first_name" type="text" value="<?= $user->getFirstName() ?>"/>
            </label>
            <label for="last_name">
                Last Name:
                <input id="last_name" name="last_name" type="text" value="<?= $user->getLastName() ?>"/>
            </label>
            <label for="primary_email">
                Email Address:
                <input id="primary_email" name="primary_email" type="text" value="<?= $user->getPrimaryEmail() ?>"/>
            </label>
            <button>Update User</button>
        </form>
    </article>
</article>