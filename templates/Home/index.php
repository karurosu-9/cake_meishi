<style>
    .box30 {
        margin: 2em 0;
        background: #f1f1f1;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.22);
    }

    .box30 .box-title {
        font-size: 1.2em;
        background: #5fc2f5;
        padding: 4px;
        text-align: center;
        color: #FFF;
        font-weight: bold;
        letter-spacing: 0.05em;
    }

    .box30 p {
        padding: 15px 20px;
        margin: 0;
    }

    .menu-list {
        font-size: 30px;
    }
</style>

<h1><?= __('Home Menu') ?></h1>
<br>
<br>
<?php if ($loginUser->admin === '管理者' || $loginUser === 'システム部') : ?>
    <div class="box30">
        <div class="box-title"><?= __('Admin Menu') ?></div>
        <div class="menu-list">
            ・<?= $this->Html->link(__('User Add'), ['controller' => 'Users', 'action' => 'add']) ?>
            <br>
            ・<?= $this->Html->link(__('Division Add'), ['controller' => 'Divisions', 'action' => 'add']) ?>
            <br>
            ・<?= $this->Html->link(__('Corps List'), ['controller' => 'Corps', 'action' => 'index']) ?>
            <br>
        </div>
    </div>
<?php else: ?>
    <div class="box30">
        <div class="box-title"><?= __('Main Menu') ?></div>
        <div class="menu-list">
            ・<?= $this->Html->link(__('Users List'), ['controller' => 'Users', 'action' => 'index']) ?>
            <br>
            ・<?= $this->Html->link(__('Corps List'), ['controller' => 'Corps', 'action' => 'index']) ?>
            <br>
        </div>
    </div>
<?php endif; ?>
