<div class="corps content">
    <h1><?= __(h($corp->corp_name)) ?></h1>
    <br>
    <br>
    <div style="font-weight: bold; color: red;">
        ※名前検索
    </div>
    <!-- 検索フォームをヘルパーメソッドから表示 -->
    <?= $this->ViewForm->generateSearchForm($meishiData) ?>
    <br>
    <br>
    <div id="add-button" class="button">
        <?= $this->Html->link(__('Meishi Add'), ['controller' => 'Meishi', 'action' => 'add']) ?>
    </div> 
    <br>
    <br>
    <table>
        <tr>
            <th><?= __('Division Name') ?></th>
            <th><?= __('title') ?></th>
            <th><?= __('employee Name') ?></th>
            <th><?= __('tel') ?></th>
            <th><?= __('address') ?></th>
            <th><?= __('Control') ?></th>
        </tr>
        <!-- 検索結果が0なら表示 -->
        <?php if ($meishiDataCount === 0) : ?>
            <tr>
                <td><?= $this->Common->displayNoDataMessage($meishiDataCount) ?></td>
            </tr>
        <?php else : ?>
            <?php foreach ($meishiData as $meishi) : ?>
                <tr>
                    <td><?= h($meishi->division) ?></td>
                    <td><?= h($meishi->title) ?></td>
                    <td><?= h($meishi->employee_name) ?></td>
                    <td><?= h($meishi->tel) ?></td>
                    <td><?= h($meishi->corp->address) ?></td>
                    <td>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Meishi', 'action' => 'edit', $meishi->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Meishi', 'action' => 'delete', $meishi->id], ['confirm' => h("『 {$meishi->employee_name} 』の名刺データをを本当に削除してもよろしいですか？")]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <!-- controllerのpaginateに指定した数以上でページネーションの表示  -->
    <?php if ($meishiDataCount >= 31) : ?>
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
    <?php endif; ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
