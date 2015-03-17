<?php
/**
 * User: Samuel
 * Date: 3/5/2015
 * Time: 11:06 PM
 */
?>
<?php

use Model\Role;

$all_roles = Role::getAllTypes()

?>
<article id="sidebar" class="distributed">
    <?php if ($role == 1): ?>
        <section class="module full-children if-js  ">
            <header>
                <h3 class="h title toggle-edit">STOP EDITING</h3>
            </header>
        </section>
    <?php endif; ?>
    <?php if ($role == 1): ?>
        <section class="module edit if-js">
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
            <section class="edit-select-decision half-children clearfix lr-float-children on-tile-sel">
                <button data-action="" class="floater edit-users">EDIT</button>
                <button data-action="" class="floater delete-users">DELETE</button>
            </section>
            <section class="full-children addendum hidden" id="user_edit_addendum">
                <form action="" id="" class="full-children">
                    <label for="users_role_edit">Change Role
                        <select name="users_role_edit" id="users_role_edit">
                            <option disabled selected> -- select a role --</option>
                            <?php foreach ($all_roles as $role_id => $correlating_role): ?>
                                <option value="<?= $role_id ?>"><?= $correlating_role ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <button>Commit changes</button>
                </form>
            </section>
        </section>
    <?php endif; ?>

    <section class="module full-children">
        <header>
            <h3 class="h title">Commodo lorem varius</h3>
        </header>
        <section class="full-children">
            Lorem ipsum dolor sit amet consectetur et sed adipiscing elit. Curabitur et vel
            sem sit amet dolor neque semper magna. Lorem ipsum dolor sit amet consectetur et dolore
            adipiscing elit. Curabitur vel sem sit.
        </section>
        <a href="#" class="button">Magna amet nullam</a>
    </section>
</article>