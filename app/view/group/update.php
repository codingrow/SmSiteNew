<?php
/**
 * User: Samuel
 * Date: 3/10/2015
 * Time: 1:27 AM
 */
use Model\Group;

/**
 * @var Group $group
 */
?>


<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <article>
        <form class="full-children" action="<?= MAIN_URL ?>group/_update" method="post">
            <label for="name">
                First Name:
                <input id="name" name="name" type="text" value="<?= $group->getName() ?>"/>
            </label>
            <label for="description">
                Description:
                <textarea name="description" id="description"><?= $group->getDescription() ?></textarea>
            </label>
            <input type="hidden" id="group_id" name="group_id" value="<?= $group->getId() ?>"/>
            <button>Update Group</button>
        </form>
    </article>
</article>