<div class="divisions cotent">
    <h1><?= __('Division Register') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($division);
    echo $this->Form->control('division_name');
    echo $this->Form->button(__('Register'));
    echo $this->Form->end();
    ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
