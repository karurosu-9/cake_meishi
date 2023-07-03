<div class="users content">
    <h1><?= __('User Edit') ?></h1>
    <br>
    <br>
    <?= $this->ViewForm->generateUserForm($user, $divisions, $usersAdminList, 'edit') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
