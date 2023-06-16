<div class="corps content">
    <h1><?= __('Corp List') ?></h1>
    <br>
    <br>
    <!--  検索フォーム -->
    <div class="searchConditions" style="font-weight: bold; color: red;">
        ※会社名検索
    </div>
    <?= $this->Common->searchForm($corps) ?>
    <table>
        <!-- 該当する企業が無かった場合に表示する -->
        <?= $this->Common->displayNoDataMessage($corpsCount) ?>
        <tr>
            <th><?= __('Corp Name') ?></th>
            <th><?= __('Corp Adress') ?></th>
            <?php if ($loginUser->admin === '管理者'): ?>
                <th><?= __('Control Panel') ?></th>
            <?php endif; ?>
        </tr>
        <?php foreach ($corps as $corp): ?>
            <tr>
                <td><?= $this->Html->link(h($corp->corp_name), ['action' => 'view', $corp->id]) ?></td>
                <td><?= h($corp->address) ?></td>
                <?php if ($loginUser->admin === '管理者') : ?>
                    <td>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $corp->id]) ?>
                        <?= $this->Form->postLink('Delete', ['action' => 'delete', $corp->id], ['confirm' => sprintf('『%s』を本当に削除してもよろしいですか？', h($corp->corp_name))]) ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?php
            echo $this->paginator->first(__('<< First'));
            echo $this->paginator->prev(__('< Prev'));
            echo $this->paginator->numbers();
            echo $this->paginator->next(__('Next >'));
            echo $this->paginator->last(__('Last >>'));
            ?>
        </ul>
    </div>
</div>
