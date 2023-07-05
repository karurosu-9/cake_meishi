<style>
    .box30 {
        margin: 2em 0;
        background: #f1f1f1;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.22);
        width: 800px;
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
        display: flex;
    }

    .left-menu {
        flex: 1;
    }

    .center-menu {
        flex: 1;
    }

    .right-menu {
        flex: 1;
    }

    .list {
        display: flex;
        justify-content: center;
    }
</style>
<div class="Home content">
    <h1><?= __('Home Menu') ?></h1>
    <br>
    <br>
    <div class="list">
        <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム') : ?>
            <div class="box30">
                <div class="box-title"><?= __('Admin Menu') ?></div>
                <div class="menu-list">
                    <div class="left-menu">
                        <p><?= __('Add') ?></p>
                        ・<?= $this->Html->link(__('User Add'), ['controller' => 'Users', 'action' => 'add']) ?>
                        <br>
                        ・<?= $this->Html->link(__('Division Add'), ['controller' => 'Divisions', 'action' => 'add']) ?>
                        <br>
                        ・<?= $this->Html->link(__('Corps Add'), ['controller' => 'Corps', 'action' => 'add']) ?>
                        <br>
                        ・<?= $this->Html->link(__('Meishi Add'), ['controller' => 'Meishi', 'action' => 'add']) ?>
                    </div>
                    <div class="center-menu">
                        <p><?= __('List') ?></p>
                        ・<?= $this->Html->link(__('Users List'), ['controller' => 'Users', 'action' => 'index']) ?>
                        <br>
                        ・<?= $this->Html->link(__('Divisions List'), ['controller' => 'Divisions', 'action' => 'index']) ?>
                        <br>
                        ・<?= $this->Html->link(__('Corps List'), ['controller' => 'Corps', 'action' => 'index']) ?>
                        <br>
                    </div>
                    <div class="right-menu">
                        <p><?= __('Estimates') ?></p>
                        ・<?= $this->Html->link(__('Estimates List'), ['controller' => 'Estimates', 'action' => 'index']) ?>
                        <br>
                        ・<?= $this->Html->link(__('Estimates Add'), ['controller' => 'Estimates', 'action' => 'add']) ?>
                        <br>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="box30">
                <div class="box-title"><?= __('Main Menu') ?></div>
                <div class="menu-list">
                    <div class="left-menu">
                        ・<?= $this->Html->link(__('Users List'), ['controller' => 'Users', 'action' => 'index']) ?>
                        <br>
                        ・<?= $this->Html->link(__('Corps List'), ['controller' => 'Corps', 'action' => 'index']) ?>
                        <br>
                    </div>
                    <div class="right-menu">
                        <?php if ($loginUser->admin === '経理') : ?>
                            ・<?= $this->Html->link(__('Estimates'), ['controller' => 'Estimates', 'action' => 'index']) ?>
                        <?php endif;  ?>
                        <br>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
