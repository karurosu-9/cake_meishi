<div class="users content">
    <h1><?= __('User Register') ?></h1>
    <br>
    <br>
    <?= $this->ViewForm->generateUserForm($user, $divisionsList, 'add') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
