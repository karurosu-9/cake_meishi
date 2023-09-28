<div class="meishi content">
    <h1><?= __('Meishi Edit') ?></h1>
    <br>
    <br>
    <h3>〘 <?= h($meishi->corp->corp_name) ?> 〙</h3>
    <!-- フォームの表示を自作ヘルパーから表示 -->
    <?= $this->ViewForm->generateMeishiForm($meishi, null, 'edit') ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['controller' => 'Meishi', 'action' => 'index']) ?>
    </div>
</div>
