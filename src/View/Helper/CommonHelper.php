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

    public function displayNoDataMessage($counter)
    {
        if ($counter === 0) {
            return '<span style="color: red; font-weight: bold;">※データは存在しません</span>';
        }
        return;
    }

    //検索フォームのヘルパーメソッド
    public function searchForm($data)
    {
        $form = '';

        $form .= $this->Form->create($data);
        $form .= $this->Form->control('keyword');
        $form .= $this->Form->button(__('Search'));
        $form .= $this->Form->end();

        return $form;
    }

    //corp用の登録、編集フォームのヘルパーメソッド
    public function corpForm($data, $action)
    {
        $form = '';

        $form .= $this->Form->create($data);
        $form .= $this->Form->control('corp_name');
        $form .= $this->Form->control('address');
        //アクションに応じてボタンの表示を変更
        if ( $action === 'add') {
            $form .= $this->Form->button(__('Register'));
        } elseif ($action === 'edit') {
            $form .= $this->Form->button(__('Edit'));
        }
        $form .= $this->Form->end();

        return $form;
    }

    //divisionの登録、編集フォームのヘルパーメソッド
    public function divisionForm($data, $action)
    {
        $form = '';

        $form .= $this->Form->create($data);
        $form .= $this->Form ->control('division_name');
        if ($action === 'add') {
            $form .= $this->Form->button(__('Register'));
        } elseif ($action === 'edit') {
            $form .= $this->Form->button(__('Edit'));
        }
        $form .= $this->Form->end();

        return $form;
    }
}
