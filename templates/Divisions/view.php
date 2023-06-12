<div class="divisions content">
    <h1><?= __(h($division->division_name)) ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create($division);
    echo $this->Form->control('keyword');
    echo $this->Form->button(__('Search'));
    echo $this->Form->end();
    ?>
    <table>
        <?php $this->Common->displayNoDataMessage($usersCount) ?>
        <tr>
            <th><?= __('User Id') ?></th>
            <th><?= __('User Name') ?></th>
            <?php if ($loginUser->admin === '管理者') : ?>
                <th><?= __('Admin') ?></th>
            <?php endif; ?>
            <th><?= __('Register') ?></th>
        </tr>
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
