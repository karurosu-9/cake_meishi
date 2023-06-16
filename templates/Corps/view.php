<div class="corps content">
    <h1><?= __(h($corp->corp_name)) ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($meishiData);
    echo $this->Form->control('keyword');
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();
    ?>
    <table>
        <!-- 検索結果が該当無しの場合表示 -->
        <?= $this->Common->displayNoDataMessage($meishiDataCount) ?>
        <tr>
            <th><?= __('Division Name') ?></th>
            <th><?= __('title') ?></th>
            <th><?= __('employee Name') ?></th>
            <th><?= __('tel') ?></th>
            <th><?= __('address') ?></th>
            <th><?= __('Control') ?></th>
        </tr>
        <?php foreach ($meishiData as $meishi) : ?>
            <tr>
                <td><?= h($meishi->division) ?></td>
                <td><?= h($meishi->title) ?></td>
                <td><?= h($meishi->employee_name) ?></td>
                <td><?= h($meishi->tel) ?></td>
                <td><?= h($meishi->corp->address) ?></td>
                <td>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Meishi', 'action' => 'edit', $meishi->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Meishi', 'action' => 'delete', $meishi->id], ['confirm' => sprintf('『%s』の名刺データをを本当に削除してもよろしいですか？', h($meishi->employee_name))]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?php
            echo $this->Paginator->first(__('<< First'));
            echo $this->Paginator->prev(__('< Prev'));
            echo $this->Paginator->numbers();
            echo $this->Paginator->next(__('Next >'));
            echo $this->Paginator->last(__('Last >>'));
            ?>
        </ul>
    </div>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
