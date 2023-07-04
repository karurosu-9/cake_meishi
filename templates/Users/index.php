<div class="users content">
    <h1><?= __('User List') ?></h1>
    <br>
    <br>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム' ) : ?>
        <div class="button" id="add-button">
            <?= $this->Html->link(__('Users Add'), ['action' => 'add']) ?>
        </div>
    <?php endif; ?>
    <br>
    <br>
    <?php
    echo $this->Form->create($users);
    echo $this->Form->control('keyword');
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();
    ?>
    <table>
        <!-- 該当するユーザーがいなかった場合表示 -->
        <?= $this->Common->displayNoDataMessage($usersCount) ?>
        <tr>
            <th><?= __('User Id') ?></th>
            <th><?= __('User Name') ?></th>
            <th><?= __('Division Name') ?></th>
            <?php if ($loginUser->admin === "管理者" || $loginUser->admin === 'システム') : ?>
                <th><?= __('Admin') ?></th>
            <?php endif; ?>
            <th><?= __('Register') ?></th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= h($user->id) ?></td>
                <td><?= $this->Html->link(h($user->user_name), ['action' => 'view', $user->id]) ?></td>
                <td><?= h($user->division->division_name) ?></td>
                <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム') : ?>
                    <td><?= h($user->admin) ?></td>
                <?php endif; ?>
                <td><?= h($user->created->format('Y-m-d H:i')) ?></td>
            </tr>
        <?php endforeach; ?>
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
</div>
