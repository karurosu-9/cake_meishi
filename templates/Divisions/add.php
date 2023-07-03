<div class="divisions cotent">
    <h1><?= __('Division Register') ?></h1>
    <br>
    <br>
    <!-- 登録フォームのヘルパーメソッド -->
    <?= $this->ViewForm->divisionForm($division, 'add') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
