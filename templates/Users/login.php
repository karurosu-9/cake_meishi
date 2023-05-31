<h1><?= __('login') ?></h1>
<br>
<br>
<?php
echo $this->Form->create();
echo '<fieldset>';
echo $this->Form->control(__('username'));
echo $this->Form->control(__('password'));
echo '</fieldset>';
echo $this->Form->button(__('Submit'));
echo $this->Form->end();
?>
