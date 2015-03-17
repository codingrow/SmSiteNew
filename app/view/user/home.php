<?php
use Model\User;
use Sm\html\HTML;

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
        <?php $user_groups = $user->findGroups()->getGroups(); ?>
        <div id="my_groups" class="clearfix">
            <?php foreach ($user_groups as $value): ?>
                <section class="tile clearfix" data-id="<?= $value->getId() ?>">
                    <div class="text clearfix">
                        <a href="<?= MAIN_URL ?>group/view/<?= $value->getAlias() ?>" class="clearfix">
                            <div class="snippet"><?= $value->getName() ?></div>
                        </a>
                    </div>
                </section>
            <?php endforeach; ?>
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