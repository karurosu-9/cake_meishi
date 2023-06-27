<?php

use App\Consts\EstimateConst;

echo $this->Html->css('estimate');
?>
<div class="estimate">
    <div class="content">
        <div class="no_print">
            <br>
            <br>
            <div class="print-button">
                <button onclick="window.print()"><?= __('Print') ?></button>
            </div>
            <?= $this->Html->link(__('Estimates List'), ['action' => 'index']) ?>
            <br>
            <br>
            <br>
            <br>
        </div>
        <div class="title">
            御見積書
        </div>
        <br>
        <br>
        <br>
        <div class="date">
            <?= h($formattedDate) ?>
        </div>
        <div class="corp">
            　<?= h($corp->corp_name) ?> 　　御中
        </div>
        <br>
        下記の通り御見積申し上げます。<br>
        <br>
        <div class="group2">
            <div class="condition">
                <div class="place">
                    受渡場所<span class="place-span1"><?= h($place) ?></span>
                </div>
                <div class="place">
                    取引条件<span class="place-span2"><?= h($conditions) ?></span>
                </div>
                <div class="place">
                    見積有効期限<span class="place-span3"><?= h($deadline) ?></span>
                </div>
                <br>
            </div>
            <div class="image">
                <?= $this->Html->image('/webroot/img/アスカプランニング角印.png', ['width' => '95px', 'height' => '95px']) ?>
            </div>
            <div class="mycorp">
                <div class="group3">
                    <div class="postal">
                        〒<?= h($postCode) ?>
                    </div>
                    <div class="address">
                        <?= h($address) ?>
                    </div>
                </div>
                <div class="corp_name">
                    <?= h($myCorpName) ?>
                </div>
                <div class="group4">
                    <div class="tel">
                        <?= h($tel) ?>
                    </div>
                    <div class="fax">
                        <?= h($fax) ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <table>
            <tr>
                <th width="620px" class="tekiyo">摘要</th>
                <th width="80px" class="unit_price">単価</th>
                <th width="80px" class="quantity">数量</th>
                <th width="120px" class="amount">金額</th>
                <th width="50px" class="note">備考</th>
            </tr>
            <?php for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) : ?>
                <?php if ($amount[$i] === null || $amount[$i] === '') {
                    break;
                } ?>
                <tr>
                    <td><?= h($tekiyo[$i]) ?></td>
                    <td><?= number_format(h($unitPrice[$i])) ?></td>
                    <td><?= h($quantity[$i]) ?></td>
                    <td><?= number_format(h($amount[$i])) . ' -' ?></td>
                    <td style="border:none;"><?= h($note[$i]) ?></td>
                </tr>
            <?php endfor; ?>
            <div>
                <tr>
                    <td colspan="1" class="total_price">合計</td>
                    <td class="none"></td>
                    <td class="none"></td>
                    <td class="all_total_price"><?= '¥' . number_format(h($totalAmount)) . ' -' ?></td>
                </tr>
            </div>
        </table>
        【<?= __('hosoku') ?>】
        <?php for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) : ?>
            <div class="hosoku">
                <?php if ($hosoku[$i] === null || $hosoku[$i] === '') {
                    break;
                } ?>
                ・<?= h($hosoku[$i]) ?>
            </div>
        <?php endfor; ?>

        <div class="no_print">
            <br>
            <br>
            <br>
            <div class="button">
                <?= $this->Html->link(__('<< BACK'), ['action' => 'index']) ?>
            </div>
            <div class="control-button" style="text-align: right;">
                <div class="button">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estimate->id]) ?>
                </div>
                <div class="button">
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estimate->id], ['confirm' => sprintf('『%s』の見積データを本当に削除してよろしいですか？', $estimate->id)]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
