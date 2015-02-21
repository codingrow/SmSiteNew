<?php
use Model\User;
use Sm\Core\Abstraction\IoC;

$char_names = ["Char-one", "C2", "Charity 3", "Ch4"];


/**
 * @var User $user
 */
if (!$user = \Sm\Core\Abstraction\IoC::$session->get("user")) {
    IoC::$response->redirect('user/login');
}
?>
<?php if ($user->getType() == 1): ?>
<div class="greeting">
    <h2>Welcome <?= $user->getUsername() ?>!</h2>
</div>

<?php else: ?>

    <div>
        <header>
            <h2>Vote for the next charity</h2>
        </header>
        <p>
            Cast your vote to choose which charity we'll donate to next.
        </p>

        <form action="charity_vote.php" method="post" class="charity_vote_form">
            <?php foreach ($char_names as $key => $value): ?>
                <input type="radio" name="charity" value="<?= $key ?>" id="char_<?= $value ?>">
                <label for="char_<?= $value ?>"><?= $value ?></label><br/>
            <?php endforeach ?>
            <input type="submit" value="Vote!"/>

        </form>
    </div>

<?php endif; ?>