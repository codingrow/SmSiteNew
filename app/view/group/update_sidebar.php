<?php
/**
 * User: Samuel
 * Date: 3/10/2015
 * Time: 2:12 AM
 */
use Sm\html\HTML;

?>
<article id="sidebar" class="distributed do_50">
    <section class="module">
        THIS GOES TO THE VIEW GROUP PAGE
        <a href="<?= MAIN_URL ?>group/view/<?= $group->getAlias() ?>" class="image featured"><?= HTML::img('telephasic/pic07.jpg') ?></a>
    </section>
    <section class="module">
        <header>
            <h3 class="h title">Elit sed feugiat</h3>
        </header>
        <section class="full-children">
            Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur et vel
            sem sit amet dolor neque semper magna. Lorem ipsum dolor sit amet consectetur et dolore
            adipiscing elit. Curabitur vel sem sit.
            <a href="#" class="button">Magna amet nullam</a>
        </section>

    </section>
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