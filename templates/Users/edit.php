<div class="users content">
    <h1><?= __('User Edit') ?></h1>
    <br>
    <br>
    <div class="button">
        <?= $this->Html->link(__('Change Password'), ['action' => 'changePassword', $user->id]) ?>
    </div>
    <br>
    <br>
    <?= $this->ViewForm->generateUserForm($user, $divisionsList, 'edit') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
