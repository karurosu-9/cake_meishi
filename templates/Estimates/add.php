<?php
use App\Consts\EstimateConst;
?>

<style>
    span {
        font-weight: bold;
        font-size: 20px;
    }
</style>

<div class="estimate content">
    <h1><?= __('Estimate') ?></h1>
    <br>
    <br>
    <?= $this->Form->create(null) ?>
    <br>
    <br>
    <br>
    <!-- 見積を出す企業の選択リスト -->
    <?= $this->Form->control('corp_id',[
        'options' => $corps,
        'label' => '会社を選択してください。',
        'style' => 'width:200px',
    ]) ?>
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
        <?php for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++): ?>
            <tr>
                <td><?= $this->Form->text('tekiyo' . $i, ['style' => 'width:200px', 'value' => $this->request->getData('tekiyo' . $i)] ) ?></td>
                <td>￥<?= $this->Form->text('unit_price' . $i, ['style' => 'width:85px', 'id' => 'unit_price' . $i, 'onChange' => 'keisan()', 'value' => $this->request->getData('unit_price' . $i)]) ?></td>
                <td><?= $this->Form->text('quantity' . $i, ['style' => 'width:50px', 'id' => 'quantity' . $i, 'onChange' => 'keisan()',  'value' => $this->request->getData('quantity' . $i)]) ?></td>
                <td>￥<?= $this->Form->text('amount' . $i, ['style' => 'width:100px', 'id'=> 'amount' . $i, 'readonly' => true, 'value' => $this->request->getData('amount' . $i)]) ?></td>
                <td><?= $this->Form->text('note' . $i, ['style' =>'width:400px', 'value' => $this->request->getData('note' . $i)]) ?></td>
            </tr>
        <?php endfor; ?>
    </table>
    <h3><?= __('Insert Hosoku') ?></h3>
    <?php for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++): ?>
        <?= $this->Form->text('hosoku' . $i, ['value' => $this->request->getData('hosoku' . $i)]) ?>
    <?php endfor; ?>
    <br>
    <br>
    <div class="button">
        <?= $this->Form->button(__('OK')) ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    function keisan() {
    for (let i = 1; i <= 5; i++) {
        //単価の値を取得
        let unit_price = document.getElementById('unit_price' + i).value;
        //数量の値を取得
        let quantity = document.getElementById('quantity' + i).value;
        //.valueを付けると値を取得しようとする為、valueは不要
        let amountElement = document.getElementById('amount' + i);

        if (unit_price !== '' && quantity !== '') {
            if (isFinite(quantity)) {
                let addAmount = unit_price * quantity;
                amountElement.value = addAmount;
            } else {
                amountElement.value = unit_price;
            }
        } else {
            amountElement.value = "";
        }
    }
}
</script>

