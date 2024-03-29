<?= $this->Html->script('corp.js') ?>
<div class="corps content">
    <h1><?= __('Corp List') ?></h1>
    <br>
    <br>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム') : ?>
        <div class="button" id="add-button">
            <?= $this->Html->link(__('Corps Add'), ['action' => 'add']) ?>
        </div>
        <br>
        <br>
    <?php endif; ?>
    <div class="button" id="add-button">
        <?= $this->Html->link(__('Meishi Add'), ['controller' => 'Meishi', 'action' => 'add']) ?>
    </div>
    <br>
    <br>
    <label style="font-weight: bold;">
        会社名を入力して絞り込む
    </label>
    <!-- 検索フォームをヘルパーメソッドから表示-->
    <?= $this->ViewForm->generateSearchQueryForm($corpsList, 'index', $keyword) ?>
    <br>
    <br>
    <table id="change-table">
        <tr>
            <th><?= __('Corp Name') ?></th>
            <th><?= __('Corp Address') ?></th>
            <?php if ($loginUser->admin === '管理者') : ?>
                <th><?= __('Control Panel') ?></th>
            <?php endif; ?>
        </tr>
        <?php foreach ($corpsList as $corp) : ?>
            <tr>
                <td><?= $this->Html->link(h($corp->corp_name), ['action' => 'view', $corp->id]) ?></td>
                <td><?= h($corp->address) ?></td>
                <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム') : ?>
                    <td>
                        <?= $this->Html->link('Edit', ['action' => 'edit', $corp->id]) ?>
                        <?= $this->Form->postLink('Delete', ['action' => 'delete', $corp->id], ['confirm' => h("『 {$corp->corp_name} 』を本当に削除してもよろしいですか？")]) ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- 検索結果が0だった時に表示する処理 -->
    <p><?= $this->Common->displayNoDataMessage($corpsCount) ?></p>
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