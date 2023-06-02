<div class="corps content">
    <h1><?= __('Corp List') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($meishiData);
    echo $this->Form->control('keyword');
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();
    ?>
    <table>
        <!-- 該当する企業が無かった場合に表示する -->
        <?= $this->Common->displayNoDataMessage($meishiCount) ?>
        <tr>
            <th><?= $this->paginator->sort(__('Corp Name')) ?></th>
            <th><?= __('Corp Address') ?></th>
            <th><?= __('Control Panel') ?></th>
        </tr>
        <?php foreach ($meishiData as $meishi) : ?>
            <tr>
                <td><?= $this->Html->link(h($meishi->corp->corp_name), ['action' => 'view', $meishi->corp->id]) ?></td>
                <td><?= h($meishi->address) ?></td>
                <?php if ($loginUser->admin === '管理者') : ?>
                    <td>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $meishi->corp->id]) ?>
                        <?= $this->Form->postLink('Delete', ['action' => 'delete', $meishi->corp->id], ['confirm' => sprintf('『%s』を本当に削除してもよろしいですか？', $meishi->corp->corp_name)]) ?>
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
