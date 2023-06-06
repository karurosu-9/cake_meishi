<div class="corps content">
    <h1><?= __('Corp Edit') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($corp);
    echo $this->Form->control('corp_name');
    echo $this->Form->control('address');
    echo $this->Form->button(__('Edit'));
    echo $this->Form->end();
    ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
