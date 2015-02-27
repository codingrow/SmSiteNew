<?php
/**
 * User: Samuel
 * Date: 2/26/2015
 * Time: 6:25 PM
 */
use Sm\Core\Abstraction\IoC;

$view = &IoC::$view;
?>
<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <?= $view->create('group/add_modal', [], 'add_modal')->content; ?>
</article>