<h1><?= __('User List') ?></h1>
<br>
<br>
<?php
echo $this->Form->create($users);
echo $this->Form->control('keyword');
echo $this->Form->button(__('Search'));
echo $this->Form->end();
?>
<table>
    <tr>
        <th><?= __('User Id') ?></th>
        <th><?= __('User Name') ?></th>
        <th><?= __('Division Name') ?></th>
        <th><?= __('Admin') ?></th>
        <th><?= __('Register') ?></th>
    </tr>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= h($user->id) ?></td>
            <td><?= $this->Html->link(h($user->userName), ['action' => 'view', $user->id]) ?></td>
            <td><?= h($user->division->divisionName) ?></td>
            <td><?= h($user->admin) ?></td>
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
