<?php

namespace App\View\Helper;

use Cake\View\Helper;

class CommonHelper extends Helper
{

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->Form = $this->_View->loadHelper('Form');
    }

    //検索結果が0の時の処理
    public function displayNoDataMessage($counter)
    {
        if ($counter === 0) {
            return '<span style="color: red; font-weight: bold;">※データは存在しません</span>';
        }
        return;
    }
}
