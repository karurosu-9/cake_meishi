<div class="users content">
    <h1><?= __('User Edit') ?></h1>
    <br>
    <br>
    <?php if ($loginUser->id === $user->id || $loginUser->admin === '管理者' || $loginUser->admin === 'システム') : ?>
    <div class="button">
        <?= $this->Html->link(__('Change Password'), ['action' => 'changePassword', $user->id]) ?>
    </div>
    <?php endif; ?>
    <br>
    <br>
    <?= $this->ViewForm->generateUserForm($user, $divisionsList, 'edit') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>