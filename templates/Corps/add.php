<h1><?= __('Crop Register') ?></h1>
<br>
<br>
<?php
echo $this->Form->create($corp);
echo $this->Form->control('corp_name');
echo $this->Form->control('address');
echo $this->Form->button(__('Register'));
echo $this->Form->end();
?>

