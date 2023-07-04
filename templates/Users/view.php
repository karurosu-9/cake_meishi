<div class="user content">
    <p></p><small>社員番号：　<?= h($user->id) ?></small></p>
    <hr>
    <h3>名前：　<?= h($user->user_name) ?></h3>
    <hr>
    <p>所属部署：　<?= h($user->division->division_name) ?></p>
    <hr>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム'): ?>
        <p>管理区分：　<?= h($user->admin) ?></p>
        <hr>
    <?php endif; ?>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム' || $loginUser->id === $user->id) : ?>
        <div class="button">
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
        </div>
    <?php endif; ?>
    <?php if ($loginUser->admin === '管理者' || $loginUser->admin === 'システム') : ?>
        <div class="button">
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => sprintf('『%s』を本当に削除してよろしいですか', h($user->user_name))]) ?>
        </div>
    <?php endif; ?>
    <br>
    <br>
    <div style="font-size: 20px">
        <?= $this->Html->link(__('<< Back'), ['action' => 'index']) ?>
    </div>
</div>