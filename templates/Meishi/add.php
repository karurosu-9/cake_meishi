<div class="meishi content">
    <h1><?= __('Meishi Register') ?></h1>
    <br>
    <br>
    <!-- フォームの表示を自作ヘルパーから表示 -->
    <?= $this->Common->meishiForm($meishi, $corps, 'add') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['controller' => 'Meishi', 'action' => 'index']) ?>
    </div>
</div>
