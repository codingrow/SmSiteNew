<?php
use Model\Image;
use Model\User;
use Model\UserImageMap;
use Sm\Core\Abstraction\IoC;
use Sm\Database\SqlModel;

/** @see Controller\BaseController */
?>
<article class=" module " id="content">
    <header>
        <h2 class="h title">{{title}}</h2>
        {{secondary_title}}
    </header>
    <article>
        <?php
        $map = new UserImageMap('user', 'image');
        $map->search_for_image_type(1);
        #var_dump($map->map(1));
        /** @var User $user */
        $user = IoC::$session->get('user');
        if ($user) {
            $user_list = [];
            $user->storeAvailableUserList($user_list);
            IoC::$session->set('available_user_list', $user_list);

        }
        var_dump($_SESSION);
        var_dump(Image::find(13));
        $table_clear_arr = ['users', 'groups', 'images', 'passwords'];
        foreach ($table_clear_arr as $table) {
            SqlModel::query_table($table, function (SqlModel $t) {
                $t->update(['id' => 0])->where('1 = 0');
                #$t->clear_table();
            });
        }
        ?>
    </article>
</article>