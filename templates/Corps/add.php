<h1><?= __('Corp Register') ?></h1>
<br>
<br>
<!-- 登録フォームの表示 -->
<?= $this->Common->corpForm($corp, 'add') ?>
<br>
<br>
<div style="font-size: 20px">
    <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
</div>

