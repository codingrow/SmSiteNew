<?php
use Model\User;
use Sm\Core\Abstraction\IoC;

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

<?php endif; ?>