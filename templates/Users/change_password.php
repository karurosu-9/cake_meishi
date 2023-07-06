<div class="users content">
    <h1><?= __('User Edit') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($user);
    echo $this->Form->control('newPassword', [
        'type' => 'password',
        'label' => 'パスワードを入力してください。',
    ]);
    echo $this->Form->control('confirmPassword', [
        'type' => 'password',
        'label' => 'もう一度パスワードを入力してください。（確認用）',
    ]);
    echo $this->Form->button(__('Change'));
    echo $this->Form->end();
    ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'view', $user->id]) ?>
    </div>
</div>