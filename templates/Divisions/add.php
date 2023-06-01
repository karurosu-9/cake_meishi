<h1><?= __('Division Register') ?></h1>
<br>
<br>
<?php
echo $this->Form->create($division);
echo $this->Form->control('division_name');
echo $this->Form->button(__('Submit'));
echo $this->Form->end();
?>
