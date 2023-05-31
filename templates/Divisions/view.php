<div class="divisions content">
    <p></p><small>社員番号：　<?= h($user->id) ?></small></p>
    <hr>
    <h3>名前：　<?= h($user->userName) ?></h3>
    <hr>
    <p>所属部署：　<?= h($user->division->divisionName) ?></p>
    <hr>
    <?php if ($loginUser->admin === '管理者'): ?>
        <div class="button">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
        </div>
        <div class="button">
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => sprintf('本当に『%s』を削除してよろしいですか', $user->userName)]) ?>
        </div>
    <?php endif; ?>
</div>
