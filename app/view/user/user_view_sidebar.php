<?php
/**
 * User: Samuel
 * Date: 3/13/2015
 * Time: 8:06 PM
 */

use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\html\HTML;
$user = User::find(IoC::$session->get('user_id'));
?>
<article id="sidebar" class="distributed">
    <section class="module full-children">
        <header>
            <h3 class="h title">About <?= $user->getUsername()?></h3>
        </header>
        <a href="#" class="image featured"><?= HTML::img($user->findProfile()->getProfile()->getUrl(), 'image', [], true) ?></a>
        <div id="profile-block" class="clearfix">
                <div id="group-main-info">
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
                    </table>
                    <div>
                        <!-- A button to edit the information in the table-->
                        <a href="<?= MAIN_URL ?>user/update" class="dummy">
                            <div id="edit-main-info" class="hardcoded">
                                edit
                            </div>
                        </a>
                    </div>
                </div>
            </div>
    </section>
</article>