<div class="Estimates content">
    <h1><?= __('Estimates List') ?></h1>
    <br>
    <br>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム部' || $loginUser->admin === '経理部') : ?>
        <div class="button" style="margin-left: 850px">
            <?= $this->Html->link(__('Estimate Add'), ['action' => 'add']) ?>
        </div>
    <?php endif; ?>
    <br>
    <br>
    <?php
    echo $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'index']]);
    echo $this->Form->control('corp_id', [
        'options' => h($options),
        'label' => '会社を選択してください。',
        'style' => 'width: 200px;',
    ]);
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();
    ?>
    <br>
    <br>
    <br>
    <?php if (!empty($corp)) : ?>
        <h3>〘<?= h($corp->corp_name) ?>の見積データ〙</h3>
    <?php endif; ?>
    <table>
        <tr>
            <th><?= __('Estimate No.') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Create User') ?></th>
        </tr>
        <?php if ($estimatesCount === 0) : ?>
            <tr>
                <td><?= $this->Common->displayNoDataMessage($estimatesCount) ?></td>
            </tr>
        <?php else : ?>
            <?php foreach ($estimates as $index => $estimate) : ?>
                <tr>
                    <td><?= $this->Html->link($estimate->id, ['action' => 'view', $estimate->id]) ?></td>
                    <td><?= h($formattedDates[$index]) ?></td>
                    <td><?= h($estimate->create_user) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <?php if (!empty($estimates)) : ?>
        <div class="paginator">
            <ul class="pagination">
                <?php
                echo $this->paginator->first('<< First');
                echo $this->paginator->prev('< Prev');
                echo $this->paginator->numbers();
                echo $this->paginator->next('Next >');
                echo $this->paginator->last('Last >>');
                ?>
            </ul>
        </div>
    <?php endif; ?>
</div>






<?php
/*
    <?php if ($estimatesCount === 0) : ?>
        <table>
            <!-- 該当する見積データが無かった場合に表示 -->
            <?= $this->Common->displayNoDataMessage($estimatesCount) ?>
            <tr>
                <th><?= __('Estimate No.') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Create User') ?></th>
            </tr>
        </table>
    <?php else : ?>
        <?php if (!empty($corp)) : ?>
            <h3>〘<?= h($corp->corp_name) ?>の見積データ〙</h3>
        <?php endif ; ?>
        <table>
            <tr>
                <th><?= __('Estimate No.') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Create User') ?></th>
            </tr>
            <?php foreach ($estimates as $index => $estimate) : ?>
                <tr>
                    <td><?= $this->Html->link($estimate->id, ['action' => 'view', $estimate->id]) ?></td>
                    <td><?= h($formattedDates[$index]) ?></td>
                    <td><?= h($estimate->create_user) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>*/
?>
