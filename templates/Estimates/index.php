<div class="Estimates content">
    <h1><?= __('Estimates List') ?></h1>
    <br>
    <br>
    <br>
    <?php
    echo $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'index']]);
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
    <?php if ($estimatesCount === 0) : ?>
        <table>
            <!-- 該当する見積データが無かった場合に表示 -->
            <?= $this->Common->displayNoDataMessage($estimatesCount) ?>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
            </tr>
        </table>
    <?php else : ?>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Create User') ?></th>
            </tr>
            <?php foreach ($estimates as $estimate) : ?>
                <tr>
                    <td><?= $this->Html->link($estimate->id, ['action' => 'view', $estimate->id]) ?></td>
                    <td><?= h($estimate->date) ?></td>
                    <td><?= h($estimate->create_user) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
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
