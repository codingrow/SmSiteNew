<?php
use Sm\Storage\Session;
use Model\Group;
?>
<section id="main" class="main container">
    <div id="primary" class="clearfix">
        <article>
            <form action="<?= MAIN_URL . 'user/_login' ?>" method="post">
                <label for="user_identifier">Username:<input type="text" id="user_identifier" name="user_identifier" title="Username"/></label>
                <label for="password">Password:<input type="password" id="password" name="password"/></label>
                <button type="submit"></button>
            </form>
        </article>

    </div>
</section>