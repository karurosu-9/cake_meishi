<?php
use App\Consts\EstimateConst;

echo $this->Html->script('estimate.js');
?>

<div class="estimate content">
    <h1><?= __('Estimate') ?></h1>
    <br>
    <br>
    <br>
    <?php
    echo $this->Form->create(null);
    //見積を出す企業の選択リスト
    echo $this->Form->control('corp_id', [
        'options' => $corps,
        'label' => '会社を選択してください。',
        'style' => 'width:200px',
    ]);
    ?>
    <br>
    <br>

    <table cellpadding="1">
        <tr>
            <th><?= __('Tekiyo') ?></th>
            <th><?= __('Unit Price') ?></th>
            <th><?= __('Quantity') ?></th>
            <th><?= __('Amount') ?></th>
            <th><?= __('Note') ?></th>
        </tr>
        <tr>
            <td><?= $this->Form->text('tekiyo1', ['style' => 'width:200px', 'value' =>h($this->request->getData('tekiyo1'))] ) ?></td>
            <td>￥<?= $this->Form->text('unit_price1', ['style' => 'width:85px', 'id' => 'unit_price1', 'onChange' => 'keisan()', 'value' => h($this->request->getData('unit_price1')), 'required' => true]) ?></td>
            <td><?= $this->Form->text('quantity1', ['style' => 'width:50px', 'id' => 'quantity1', 'onChange' => 'keisan()',  'value' => h($this->request->getData('quantity1')), 'required' => true]) ?></td>
            <td>￥<?= $this->Form->text('amount1', ['style' => 'width:100px', 'id'=> 'amount1', 'readonly' => true, 'value' => h($this->request->getData('amount1'))]) ?></td>
            <td><?= $this->Form->text('note1', ['style' =>'width:400px', 'value' => h($this->request->getData('note1'))]) ?></td>
        </tr>
        <?php for ($i = 2; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++): ?>
            <tr>
                <td><?= $this->Form->text('tekiyo' . $i, ['style' => 'width:200px', 'value' => h($this->request->getData('tekiyo' . $i))] ) ?></td>
                <td>￥<?= $this->Form->text('unit_price' . $i, ['style' => 'width:85px', 'id' => 'unit_price' . $i, 'onChange' => 'keisan()', 'value' => h($this->request->getData('unit_price' . $i))]) ?></td>
                <td><?= $this->Form->text('quantity' . $i, ['style' => 'width:50px', 'id' => 'quantity' . $i, 'onChange' => 'keisan()',  'value' => h($this->request->getData('quantity' . $i))]) ?></td>
                <td>￥<?= $this->Form->text('amount' . $i, ['style' => 'width:100px', 'id'=> 'amount' . $i, 'readonly' => true, 'value' => h($this->request->getData('amount' . $i))]) ?></td>
                <td><?= $this->Form->text('note' . $i, ['style' =>'width:400px', 'value' => h($this->request->getData('note' . $i))]) ?></td>
            </tr>
        <?php endfor; ?>
    </table>
    <h3><?= __('Insert Hosoku') ?></h3>
    <?php for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++): ?>
        <?= $this->Form->text('hosoku' . $i, ['value' => h($this->request->getData('hosoku' . $i))]) ?>
    <?php endfor; ?>
    <br>
    <br>
    <div class="button">
        <?= $this->Form->button(__('OK')) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
