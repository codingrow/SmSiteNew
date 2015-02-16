<?php
use Model\Image;
use Model\User;
use Model\UserImageMap;
use Sm\Core\Abstraction\IoC;
use Sm\Database\PDO\Sql;
use Sm\Database\Schema;
use Sm\Database\SqlModel;
    /** @see Controller\BaseController */
?>
<section id="main" class="main container">
    <div id="primary" class="clearfix">
        <article>
            <?php
            $map = new UserImageMap('user', 'image');
            $map->search_for_image_type(1);
            #var_dump($map->map(1));
                /** @var User $user */
                $user = IoC::$session->get('user');
            if($user){
                $user_list = [];
                $user->storeAvailableUserList($user_list);
                IoC::$session->set('available_user_list', $user_list);

            }
                var_dump($_SESSION);
            var_dump(Image::find(13));
            $table_clear_arr = ['users', 'groups','images', 'passwords'];
            foreach ($table_clear_arr as $table ) {
                SqlModel::query_table($table, function(SqlModel $t){
                    $t->update(['id'=>0])->where('1 = 0');
                    #$t->clear_table();
                });
            }
            ?>
        </article>
    </div>
</section>