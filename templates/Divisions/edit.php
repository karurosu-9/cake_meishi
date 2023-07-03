<div class="divisions content">
    <h1><?= __('Division Edit') ?></h1>
    <br>
    <br>
    <?= $this->ViewForm->divisionForm($division, 'edit') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
