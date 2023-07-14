<div class="Estimates content">
    <h1><?= __('Estimates List') ?></h1>
    <br>
    <br>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム' || $loginUser->admin === '経理') : ?>
    <div class="button" style="margin-left: 850px">
        <?= $this->Html->link(__('Estimate Add'), ['action' => 'add']) ?>
    </div>
    <?php endif; ?>
    <br>
    <br>
    <!-- フォームをヘルパーメソッドから表示 -->
    <?= $this->ViewForm->generateSearchListForm($corpsList, 'corp_id', 'index') ?>
    <br>
    <br>
    <br>
    <?php if (!empty($corp)) : ?>
    <h3>【<?= h($corp->corp_name) ?>の見積データ】</h3>
    <?php endif; ?>
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
    </table>
    <!-- 検索結果が0だった時に表示する処理 -->
    <td><?= $this->Common->displayNoDataMessage($estimatesCount) ?></td>
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