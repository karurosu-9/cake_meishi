<h1><?= __('Edit') ?></h1>
<br>
<br>
<?php
echo $this->Form->create($user);
echo $this->Form->control('division_id',[
    'options' => $divisions,

]);
echo $this->Form->control('userName');
echo $this->Form->control('password');
echo $this->Form->control('admin',[
    'options' => [
        '一般' => '一般',
        '経理' => '経理',
    ],
    'value' => '一般',
]);
echo $this->Form->button(__('Submit'));
?>
