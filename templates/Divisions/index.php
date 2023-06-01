<h1><?= __('Dvisions List') ?></h1>
<br>
<br>
<?php
echo $this->Form->create($divisions);
echo $this->Form->control('keyword');
echo $this->Form->button(__('Search'));
echo $this->Form->end();
?>
<table>
    <tr>
        <th><?= __('Division Name') ?></th>
        <th><?= __('Control Panel') ?></th>
    </tr>
    <?php foreach ($divisions as $division) : ?>
        <tr>
            <td><?= $this->Html->link(h($division->division_name), ['action' => 'view', $division->id]) ?></td>
            <td>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $division->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $division->id], ['confirm' => sprintf('『%s』を本当に削除してもよろしいですか？', $division->division_name)]) ?>
            </td>
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
