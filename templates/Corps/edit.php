<div class="corps content">
    <h1><?= __('Corp Edit') ?></h1>
    <br>
    <br>
    <!-- 編集用のフォームをヘルパーメソッドで表示 -->
    <?= $this->ViewForm->corpForm($corp, 'edit') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
