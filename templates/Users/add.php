<div class="users content">
    <h1><?= __('User Register') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($user);
    echo $this->Form->control('division_id', [
        'options' => [
            '' => '-- 所属部署を選択してください。--',
            $divisions,
        ],
        'value' => '-- 所属部署を選択してください。--',

    ]);
    echo $this->Form->control('user_name');
    echo $this->Form->control('password');
    echo $this->Form->control('admin', [
        'options' => [
            '' => '権限を選択してください。',
            '一般' => '一般',
            '経理' => '経理',
            'システム' => 'システム',
        ],
        'value' => '権限を選択してください。',
    ]);
    echo $this->Form->button(__('Register'));
    echo $this->Form->end();
    ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
