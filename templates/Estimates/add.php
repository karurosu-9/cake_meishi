<?= $this->Html->script('estimate.js') ?>
<div class="estimate content">
    <h1><?= __('Estimate') ?></h1>
    <br>
    <br>
    <br>
    <?= $this->ViewForm->generateEstimateForm($options, $postData, 'add') ?>
</div>

