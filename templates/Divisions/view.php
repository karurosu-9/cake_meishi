<div class="divisions content">
    <h1><?= __(h($division->division_name)) ?></h1>
    <br>
    <br>
    <div style="font-weight: bold; color: red;">
        ※名前検索
    </div>
    <!-- 検索フォームをヘルパーメソッドから表示 -->
    <?= $this->ViewForm->generateSearchForm($users) ?>
    <table>
        <tr>
            <th><?= __('User Id') ?></th>
            <th><?= __('User Name') ?></th>
            <?php if ($loginUser->admin === '管理者') : ?>
                <th><?= __('Admin') ?></th>
            <?php endif; ?>
            <th><?= __('Register') ?></th>
        </tr>
        <!-- 検索結果が0なら表示 -->
        <?php if ($usersCount === 0) : ?>
            <tr>
                <td><?= $this->Common->displayNoDataMessage($usersCount) ?></td>
            </tr>
        <?php else : ?>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $this->Html->link(h($user->user_name), ['controller' => 'Users', 'action' => 'view', $user->id]) ?></td>
                    <?php if ($loginUser->admin === '管理者') : ?>
                        <td><?= h($user->admin) ?></td>
                    <?php endif; ?>
                    <td><?= h($user->created) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
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
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>
