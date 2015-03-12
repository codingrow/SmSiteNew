<?php
/**
 * User: Samuel
 * Date: 3/4/2015
 * Time: 6:26 PM
 */
use Model\Group;
use Model\User;

/** @var Group $group */
/** @var User $user */

$founder = User::find($group->getFounderId());
$group_users = $group->getUsers();
$role = 2;
if ($user != false && array_key_exists($user->getUsername(), $group_users)) {
    $role = $group_users[$user->getUsername()]->getGroupContext()['role_id'];
}
?>

    <script>
        $(function () {
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
        })
    </script>
<?php foreach ($group_users as $user_in_group): ?>
    <section class="user-tile clearfix" data-id="<?= $user_in_group->getId() ?>">
        <div class="text clearfix">
            <a href="<?= MAIN_URL ?>user/view/<?= $user_in_group->getUsername() ?>" class="clearfix">
                <div class="snippet"><?= $user_in_group->getFirstName() ?>&nbsp;<?= $user_in_group->getLastName() ?></div>
                <div class="snippet"><em><?= $user_in_group->getUsername() ?></em></div>
                <?php if ($role == 1): ?>
                    <div class="edit edit-user clearfix">
                        <div class="editing-select">
                            Select
                        </div>
                        <div class="editing-edit">
                            Edit
                        </div>
                    </div>
                <?php endif; ?>
            </a>
        </div>
    </section>
<?php endforeach; ?>