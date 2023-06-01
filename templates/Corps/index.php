<h1><?= __('Corp List') ?></h1>
<br>
<br>
<?php
echo $this->Form->create($corps);
echo $this->Form->control('keyword');
echo $this->Form->button(__('Search'));
echo $this->Form->end();
?>
<table>
    <tr>
        <th><?= __('Corp Name') ?></th>
    </tr>
    <?php foreach ($corps as $corp) : ?>
        <tr>
            <td><?= $this->Html->link(h($corp->corp_name), ['action' => 'view', $corp->id]) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="paginator">
    <ul class="pagination">
        <?php
        echo $this->paginator->first(__('<< First'));
        echo $this->paginator->prev(__('< Prev'));
        echo $this->paginator->numbers();
        echo $this->paginator->next(__('Next >'));
        echo $this->paginator->last(__('Last >>'));
        ?>
    </ul>
</div>
