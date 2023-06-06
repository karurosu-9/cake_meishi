<div class="user content">
    <p></p><small>社員番号：　<?= h($user->id) ?></small></p>
    <hr>
    <h3>名前：　<?= h($user->user_name) ?></h3>
    <hr>
    <p>所属部署：　<?= h($user->division->division_name) ?></p>
    <hr>
    <?php if ($loginUser->admin === '管理者'): ?>
        <div class="button">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
        </div>
        <div class="button">
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => sprintf('本当に『%s』を削除してよろしいですか', $user->user_name)]) ?>
        </div>
    <?php endif; ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>

