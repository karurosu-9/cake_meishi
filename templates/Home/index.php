
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
