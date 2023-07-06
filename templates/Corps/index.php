<div class="corps content">
    <h1><?= __('Corp List') ?></h1>
    <br>
    <br>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム' ): ?>
        <div class="button" id="add-button">
            <?= $this->Html->link(__('Corps Add'), ['action' => 'add']) ?>
        </div>
        <br>
        <br>
    <?php endif; ?>
    <div class="button">
        <?= $this->Html->link(__('Meishi Add'), ['controller' => 'Meishi', 'action' => 'add']) ?>
    </div>
    <br>
    <br>
    <div class="searchConditions" style="font-weight: bold; color: red;">
        ※会社名検索
    </div>
    <!--  検索フォームをヘルパーメソッドから表示 -->
    <?= $this->ViewForm->generateListSearchForm($corpsList) ?> <!-- <//?= $this->ViewForm->generateSearchForm($corps) ?> -->
    <br>
    <br>
    <table>
        <tr>
            <th><?= __('Corp Name') ?></th>
            <th><?= __('Corp Address') ?></th>
            <?php if ($loginUser->admin === '管理者') : ?>
                <th><?= __('Control Panel') ?></th>
            <?php endif; ?>
        </tr>
        <!-- 検索結果が0なら表示 -->
        <?php if ($corpsCount === 0) : ?>
            <tr>
                <td><?= $this->Common->displayNoDataMessage($corpsCount) ?></td>
            </tr>
        <!-- リストから選択した会社の表示 -->
        <?php elseif (!empty($searchCorp)) : ?>
            <tr>
                <td><?= $this->Html->link(h($searchCorp->corp_name), ['action' => 'view', $searchCorp->id]) ?></td>
                <td><?= h($searchCorp->address) ?></td>
                <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム') : ?>
                    <td>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit',$searchCorp->id]) ?>
                        <?= $this->Form->postLink('Delete', ['action' => 'delete', $searchCorp->id], ['confirm' => h("『 {$searchCorp->corp_name} 』を本当に削除してもよろしいですか？")]) ?>
                    </td>
                <?php endif; ?>
            </td>
        <?php else :?>
            <?php foreach ($corps as $corp) : ?>
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
        <?php endif; ?>
    </table>
    <!-- controllerのpaginateに指定した数以上でページネーションの表示 -->
    <?php if ($corpsCount >= 31) : ?>
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
    <?php endif ; ?>
</div>
