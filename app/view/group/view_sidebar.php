<?php
/**
 * User: Samuel
 * Date: 3/5/2015
 * Time: 11:06 PM
 */
?>
<?php use Sm\html\HTML; ?>
<article id="sidebar" class="distributed do_50">
    <section class="module full-children">
        <a href="#" class="image featured"><?= HTML::img('telephasic/pic07.jpg') ?></a>
        <?php if ($role == 1): ?>
            <button class="toggle-edit">STOP EDITING</button>
        <?php endif; ?>
    </section>
    <?php if ($role == 1): ?>
        <section class="module edit">
            <section class="full-children">
                <form action="<?= MAIN_URL ?>group/_add_user" id="add_user_form" method="post" class="full-children">
                    <input type="hidden" value="<?= $group->getId() ?>" name="group_id"/>

                    <div class="baby-row">
                        Add User:
                    </div>
                    <label for="user_add" class="floater">
                        <select name="user_add[]" id="user_add" multiple="multiple"></select>
                    </label>
                    <button class="floater">Add</button>
                </form>

            </section>
        </section>
    <?php endif; ?>

    <section class="module">
        <header>
            <h3 class="h title">Commodo lorem varius</h3>
        </header>
        <section class="full-children">
            Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur et vel
            sem sit amet dolor neque semper magna. Lorem ipsum dolor sit amet consectetur et dolore
            adipiscing elit. Curabitur vel sem sit.
            <a href="#" class="button">Magna amet nullam</a>
        </section>
    </section>
</article>