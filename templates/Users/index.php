<h1><?= __('User List') ?></h1>
<br>
<br>
<table>
    <tr>
        <th><?= __('User Name') ?></th>
        <th><?= __('Division Name') ?></th>
        <th><?= __('Admin') ?></th>
        <th><?= __('Register') ?></th>
    </tr>
    <tr>
        <?php foreach ($users as $user) : ?>
            <td><?= $this->Html->link(h($user->userName), ['action' => 'view']) ?></td>
            <td><?= h($user->division) ?></td>
            <td><?= h($user->admin) ?></td>
            <td><?= h($user->created) ?></td>
        <?php endforeach; ?>
    </tr>
</table>
