<?php
use Controller\groupController;
use Model\Group;
use Model\User;
use Sm\html\HTML;

/** @var Group $group */
/** @var User $user */
/** @var User $founder */


?>
<?= HTML::inc_js(PACKAGE_URL . 'js/select2/dist/js/select2.min.js', true) ?>
<?= HTML::inc_js('toggle-edit') ?>
<?= HTML::link(PACKAGE_URL . 'js/select2/dist/css/select2.css', 'css', true) ?>
<script>
    $(function () {
        //toggle edit selected
        $('.edit-select-decision').on('click', '*', function () {
            var elem = $(this);
            elem.blur();
        });
        $('.edit-users').on('click', function (e) {
            var elem = $(this);
            var parent_section = elem.parents('section').get(0);
            id = $(parent_section).data().id;
            if (!elem.hasClass('selected')) {
                elem.addClass('selected');
                $('#user_edit_addendum').show();
            } else {
                elem.removeClass('selected');
                $('#user_edit_addendum').hide();
            }
        });

        var select2select = $('#user_add');
        /** INITIALIZE THE LIST OF USERS TO ADD, REMOVE MEMBERS THAT ARE ALREADY PART OF THE GROUP FROM THE LIST OF POTENTIALS**/
        //todo figure out how to add members after initializing select2
        var members = [];
        var find_member_usernames = function () {
            $.ajax("<?= MAIN_URL ?>group/_members/<?= $group->getAlias()?>").done(function (data) {
                members = data;
            });
        };
        find_member_usernames();
        $('.edit-select-decision').on('click', '.delete-users', function (e) {
            setTimeout(find_member_usernames, 200);
        });

        select2select.select2({
            tags: true,
            tokenSeparators: [','],
            ajax: {
                url: "<?= MAIN_URL ?>group/test_feed",
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
                        select2select.val(null).trigger("change");;
                        find_member_usernames();
                    } else {
//                        alert(response.text)
                    }
                }
            });
        });

        var member_arr = [];

        $('#user_edit_addendum').on('submit', 'form', function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?= MAIN_URL ?>group/_upd_user",
                data: {
                    user_id: member_arr,
                    group_id: <?= $group->getId()?>,
                    role_id: $('#users_role_edit').val()
                },
                type: 'POST',
                complete: function (data) {
                    member_arr = [];
                    var response = JSON.parse(data.responseText);
                    if (Array.isArray(response)) {
                        for (var i = 0; i < response.length; i++) {
                            var this_response = response[i];
                            var resp_text = response[i].text;
                            if (resp_text != true) {
                                alert(resp_text)
                            }
                        }
                    }
                    $("#members").load("<?= MAIN_URL ?>group/_html_user/<?= $group->getAlias()?>");
                }
            })
        });

        /** DELETE A MEMBER FROM THE GROUP **/
        $('#members').on('click', '.edit-user div', function (e) {
            e.preventDefault();
        });
        $('#members').on('click', '.edit-user .editing-select', function (e) {
            e.preventDefault();
            var elem = $(this);
            var parent_section = elem.parents('section').get(0);
            id = $(parent_section).data().id;
            if (!elem.hasClass('selected')) {
                member_arr.push(id);
                elem.addClass('selected');
            } else {
                var index = member_arr.indexOf(id);
                if (index != 1) {
                    member_arr.splice(index, 1);
                }
                elem.removeClass('selected');
            }
            console.log(member_arr);
        });

        $('.edit-select-decision').on('click', '.delete-users', function (e) {
            $.ajax({
                url: "<?= MAIN_URL ?>group/_del_user",
                data: {
                    user_id: member_arr,
                    group_id: <?= $group->getId()?>
                },
                type: 'POST',
                complete: function (data) {
                    member_arr = [];
                    var response = JSON.parse(data.responseText);
                    if (Array.isArray(response)) {
                        for (var i = 0; i < response.length; i++) {
                            var this_response = response[i];
                            var resp_text = response[i].text;
                            if (resp_text != true) {
                                if (this_response.hasOwnProperty('username')) {
                                    alert('Sorry, ' + this_response['username'] + ' could not be deleted at this time because ' + resp_text)
                                } else {
                                    alert(resp_text)
                                }
                            }
                        }
                    }
                    $("#members").load("<?= MAIN_URL ?>group/_html_user/<?= $group->getAlias()?>");
                }
            });
        });
        $('.edit-select-decision').on('submit', '#user_edit_addendum form', function (e) {
            $.ajax({
                url: "<?= MAIN_URL ?>group/_del_user",
                data: {
                    user_id: member_arr,
                    group_id: <?= $group->getId()?>
                },
                type: 'POST',
                complete: function (data) {
                    member_arr = [];
                    var response = JSON.parse(data.responseText);
                    if (Array.isArray(response)) {
                        for (var i = 0; i < response.length; i++) {
                            var this_response = response[i];
                            var resp_text = response[i].text;
                            if (resp_text != true) {
                                if (this_response.hasOwnProperty('username')) {
                                    alert('Sorry, ' + this_response['username'] + ' could not be deleted at this time because ' + resp_text)
                                } else {
                                    alert(resp_text)
                                }
                            }
                        }
                    }
                    $("#members").load("<?= MAIN_URL ?>group/_html_user/<?= $group->getAlias()?>");
                }
            });
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
                <?php if ($founder->getId()): ?>
                    <tr>
                        <td>Founder:</td>
                        <td><?= $founder->getUsername() ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>About:</td>
                    <td><?= $group->getDescription() ?></td>
                </tr>
            </table>
            <?php if ($role == 1): ?>
                <div class="edit">
                    <!-- A button to edit the information in the table-->
                    <a href="<?= MAIN_URL ?>group/update/<?= $group->getAlias() ?>" class="dummy">
                        <div id="edit-main-info" class="hardcoded">
                            Edit
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    $group_users = $group->findUsers()->getUsers();
//    var_dump($group_users);
    ?>
    <article id="members" class="clearfix">
        <?= groupController::get()->_html_user($group) ?>
    </article>
</article>