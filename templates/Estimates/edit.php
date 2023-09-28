<?php
echo $this->Html->script('estimate.js');
?>

<div class="estimate content">
    <h1><?= __('Estimate') ?></h1>
    <br>
    <br>
    <br>
    <h2><?= h($estimate->corp->corp_name) ?>への見積作成</h2>
    <br>
    <br>
    <?= $this->ViewForm->generateEstimateForm($estimateDate, $estimate, 'edit') ?>
</div>
