<?php
namespace App\View\Helper;

use Cake\View\Helper;

class CommonHelper extends Helper
{

    public function initialize(array $config) :void
    {
        parent::initialize($config);
        $this->Form = $this->_View->loadHelper('Form');
    }

    public function displayNoDataMessage($counter)
    {
        if ($counter === 0) {
            return '<span style="color: red; font-weight: bold;">※データは存在しません</span>';
        }
        return;
    }
    //検索フォーム用ヘルパーメソッド
    public function SearchForm($data)
    {
        $formContent = "";

        $formContent .= $this->Form->create($data);
        $formContent .= $this->Form->control('keyword');
        $formContent .= $this->Form->button(__('Search'));
        $formContent .= $this->Form->end();

        return $formContent;
    }
}
?>
