<?php
use Controller\userController;
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
        Groups:
        <?php $user_groups = $user->findGroups()->getGroups();?>
        <div id="my_groups" class="clearfix">
            <?= userController::get()->_html_groups()?>
            <section class="tile clearfix">
                <div class="text clearfix">
                    <a class="clearfix" href="<?= MAIN_URL ?>group/create/">
                        <div class="snippet">~Add Group</div>
                    </a>
                </div>
            </section>
        </div>
    </article>
</article>