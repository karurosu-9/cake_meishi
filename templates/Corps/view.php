<?= $this->Html->script('corp.js') ?>
<div class="corps content">
    <h1><?= __(h($corp->corp_name)) ?></h1>
    <br>
    <br>
    <!-- リストから絞り込み検索をしてjavascriptで表示する処理 -->
    <label style="font-weight: bold;" for="select-division">
        リストから部署を選択して絞り込む
    </label>
    <select id="select-division" style="width: 250px">
        <?php foreach ($formDivisionsList as $division) : ?>
            <option value="<?= $division ?>"><?= h($division) ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <br>
    <table id="change-table">
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
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Meishi', 'action' => 'delete', $meishi->id], ['confirm' => h("『 {$meishi->employee_name} 』の名刺データをを本当に削除してもよろしいですか？")]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- 検索結果が0だった時の表示する処理 -->
    <p class="no-data-message" style="display: none">※名刺データはありません。</p>
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