<div class="Estimates content">
    <h1><?= __('Estimates List') ?></h1>
    <br>
    <br><br>
    <?php
    echo $this->Form->create(null, ['url' => ['type' => 'get']]);
    echo $this->Form->control('corp_id', [
        'options' => $corps,
        'label' => '会社を選択してください。',
        'style' => 'width: 200px;',
    ]);
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();
    ?>
    <br>
    <br>
    <?php if (!empty($estimates)) : ?>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Create User') ?></th>
            </tr>
            <?php foreach ($estimates as $estimate) : ?>
                <tr>
                    <td><?= $estimate->id ?></td>
                    <td><?= $estimate->date ?></td>
                    <td><?= $estimate->create_user ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <table>
            <!-- 該当する見積データが無かった場合に表示 -->
            <?= $this->Common->displayNoDataMessage($estimatesCount) ?>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
            </tr>
    <?php endif; ?>
</div>
