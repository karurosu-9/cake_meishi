<div class="users content">
    <h1><?= __('User Login') ?></h1>
    <br>
    <br>
    <?php
    echo $this->Form->create();
    echo '<fieldset>';
    echo $this->Form->control(__('user_name'));
    echo $this->Form->control(__('password'));
    echo '</fieldset>';
    echo $this->Form->button(__('Login'));
    echo $this->Form->end();
    ?>
</div>
