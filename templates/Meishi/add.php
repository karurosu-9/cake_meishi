<div class="meishi content">
    <h1><?= __('Meishi Register') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($meishi);
    echo $this->Form->control('corp_id', [
        'options' => $corps,

    ]);
    echo $this->Form->control('division');
    echo $this->Form->control('title');
    echo $this->Form->control('employee_name');
    echo $this->Form->control('tel');
    echo $this->Form->button(__('Register'));
    echo $this->Form->end();
    ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['controller' => 'Meishi', 'action' => 'index']) ?>
    </div>
</div>