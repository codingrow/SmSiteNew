<?php
use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\html\HTML;

/**
 * @var User $user
 */
if (!$user = \Sm\Core\Abstraction\IoC::$session->get("user")) {
    IoC::$response->redirect('user/login');
}
?>
<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <div id="profile-block" class="clearfix">
        <div id="profile-pic">
            <?= HTML::img($user->getProfile()->getUrl(), 'User Profile', [], true) ?>
        </div>
        <div id="profile-main-info">
            <table>
                <tr>
                    <td>Name:</td>
                    <td><?= $user->getFirstName() . ' ' . $user->getLastName() ?></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><?= $user->getUsername() ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td class=""><?= $user->getPrimaryEmail() ?></td>
                </tr>
                <tr>
                    <td>Location:</td>
                    <td class="hardcoded">Slaminois <sub>(private)</sub></td>
                </tr>
            </table>
            <div>
                <!-- A button to edit the information in the table-->
                <a href="#/" class="dummy">
                    <div id="edit-main-info" class="hardcoded">
                        edit
                    </div>
                </a>
            </div>
        </div>

    </div>
    <article>
        {{secondary_title}}
        <a href="">
            <div class="tile">
                <div class="tile-holder">
                    <?= HTML::img('telephasic/pic04.jpg') ?>
                </div>
            </div>
        </a>
        <?php
        $user->findAvailableUsers();
        //var_dump($_SESSION);
        $user->findGroups();
        var_dump($user->getGroups());
        ?>

    </article>
</article>