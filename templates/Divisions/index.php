<div class="divisions content">
    <h1><?= __('Dvisions List') ?></h1>
    <br>
    <br>
    <label style="font-weight: bold;">
        部署名を入力して絞り込み検索
    </label>
    <!-- 検索フォームをヘルパーメソッドから表示 -->
    <?= $this->ViewForm->generateSearchQueryForm($divisions, 'index') ?>
    <table>
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
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $division->id], ['confirm' => h("『 {$division->division_name} 』を本当に削除してもよろしいですか？")]) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
    </table>
    <p><?= $this->Common->displayNoDataMessage($divisionsCount) ?></p>
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
