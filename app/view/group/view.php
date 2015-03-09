<?php
use Model\Group;
use Model\User;
use Sm\Core\Abstraction\IoC;
use Sm\html\HTML;

/** @var Group $group */
/** @var User $user */
?>
<?= HTML::inc_js(PACKAGE_URL . 'js/select2/dist/js/select2.min.js', true) ?>
<?= HTML::link(PACKAGE_URL . 'js/select2/dist/css/select2.min.css', 'css', true) ?>
<script>
    $(function () {
        var select2select = $('#user_add');

        /** necessary to make a toggle plugin ? **/
        var no_edit = false;
        $('.toggle-edit').on('click', function (e) {
            if (!no_edit) {
                $('.edit').hide();
                $(this).text('EDIT');
                no_edit = true
            }
            else {
                $('.edit').show();
                $(this).text('STOP EDITING');
                no_edit = false
            }
        });

        /** DELETE A MEMBER FROM THE GROUP **/
        $('#members').on('click', '.edit-user.delete', function (e) {
            e.preventDefault();
            var id;
            //member ID stored in data attribute of section that holds the tile
            var parent_section = $(this).parents('section').get(0);
            id = $(parent_section).data().id;
            $.ajax({
                url: "<?= MAIN_URL ?>group/_del_user",
                data: 'user_id=' + id + '&group_id=' + '<?=$group->getId()?>',
                type: 'POST',
                complete: function (data) {
                    var response = JSON.parse(data.responseText);
                    if (response.text == 'true' || response.text == true) {
                        $("#members").load("<?= MAIN_URL ?>group/_html_user/<?= $group->getAlias()?>");
                    } else {
                        alert(response.text)
                    }
                }
            });
        });
        /** ADD MEMBERS TO THE GROUP. USER ROLES ARE NOT INCLUDED HERE **/
        $('#add_user_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                data: $(this).serialize(),
                method: 'POST',
                complete: function (data) {
                    var response = JSON.parse(data.responseText);
                    if (!response.text || response.text == 'true' || response.text == true) {
                        $("#members").load("<?= MAIN_URL ?>group/_html_user/<?= $group->getAlias()?>");
                        select2select.val(null).trigger("change")
                    } else {
                        alert(response.text)
                    }
                }
            });
        });

        /** INITIALIZE THE LIST OF USERS TO ADD, REMOVE MEMBERS THAT ARE ALREADY PART OF THE GROUP FROM THE LIST OF POTENTIALS**/
        /** todo make each tile based on this javascript list ? */
        $.ajax("http://localhost/SmSiteNew/group/_members/<?= $group->getAlias()?>").done(function (members) {
            select2select.select2({
                tags: true,
                tokenSeparators: [','],
                ajax: {
                    url: "http://localhost/SmSiteNew/group/test_feed",
                    dataType: 'json',
                    data: function (params) {
                        if (params === {} || params.term == "") {
                            return {q: '*' /* Search Term*/};
                        }
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, page) {
                        return data;
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                templateResult: function (item) {
                    if (item.text && item.text !== item.id && members.indexOf(item.text) == -1) {
                        return item.text;
                    }
                },
                templateSelection: function (item) {
                    return item.text;
                }
            });
            /** PREVENT THE SELECT DIALOG FROM CLOSING AFTER EVERY SELECT OR UNSELECT, ENABLING MULTISELECT **/
            function open_sel2() {
                select2select.select2("open");
            }

            select2select.on('select2:select', open_sel2);
            select2select.on('select2:unselect', open_sel2);
        });
    });

</script>

<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <div id="profile-block" class="clearfix">
        <div id="group-main-info">
            <table>
                <tr>
                    <td>Name:</td>
                    <td><?= $group->getName() ?></td>
                </tr>
                <?php if ($founder->getId()): ?>
                    <tr>
                        <td>Founder:</td>
                        <td><?= $founder->getUsername() ?></td>
                    </tr>
                <?php endif; ?>
            </table>
            <?php if ($role == 1): ?>
                <div class="edit">
                    <!-- A button to edit the information in the table-->
                    <a href="#" class="dummy">
                        <div id="edit-main-info" class="hardcoded">
                            Edit
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <article id="members" class="clearfix">
        <?= IoC::$view->create('group/html_users', ['group' => $group, 'user' => $user])->content; ?>
    </article>
    <?php if ($role == 1): ?>
        <article>

        </article>
    <?php endif; ?>
</article>