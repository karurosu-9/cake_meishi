<div class="divisions content">
    <h1><?= __('Dvisions List') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($divisions);
    echo $this->Form->control('keyword');
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();
    ?>
    <table>
        <!-- 作成したヘルパーメソッド：　検索結果がなければ表示 -->
        <?= $this->Common->displayNoDataMessage($divisionsCount) ?>
        <tr>
            <th><?= __('Division Name') ?></th>
            <?php if ($loginUser->admin === '管理者') : ?>
                <th><?= __('Control Panel') ?></th>
            <?php endif; ?>
        </tr>
        <?php foreach ($divisions as $division) : ?>
            <tr>
                <td><?= $this->Html->link(h($division->division_name), ['action' => 'view', $division->id]) ?></td>
                <?php if ($loginUser->admin === '管理者') : ?>
                    <td>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $division->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $division->id], ['confirm' => sprintf('『%s』を本当に削除してもよろしいですか？', h($division->division_name))]) ?>
                    </td>
                <?php endif; ?>
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
</div>
