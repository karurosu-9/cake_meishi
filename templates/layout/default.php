<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'layout']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <div class="no_print">
        <?php
        $loginUser = $this->request->getAttribute('identity');
        ?>
        <nav class="top-nav">
            <!-- ログインユーザーであれば表示する -->
            <?php if ($loginUser) : ?>
                <div class="top-nav-title">
                    <?= $this->Html->link(__('Home'), ['controller' => 'Home', 'action' => 'index']) ?>
                </div>
                <div class="top-nav-links" style="margin-left: 600px">
                    <?= $this->Html->link(__('logout'), ['controller' => 'Users', 'action' => 'Logout']) ?>
                    <a target="_blank" rel="noopener" href="https://api.cakephp.org/">API</a>
                </div>
                <span style="font-weight: bold;"> | </span>
                <div>
                    <span style="font-weight: bold">ログインユーザー: 『<?= $this->Html->link(h($loginUser->user_name), ['controller' => 'Users', 'action' => 'view', $loginUser->id]) ?>』</span>
                </div>
            <?php endif; ?>
        </nav>
    </div>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>

</html>
