<?php

namespace App\View\Helper;

use App\Consts\EstimateConst;
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
        //文字列のみ、もしくは文字列と数字は受け付けるが、数字のみは受け付けない仕様
        $form .= $this->Form->control('keyword', ['pattern' => '^(?=.*[a-zA-Zぁ-んァ-ヶー一-龠])[a-zA-Zぁ-んァ-ヶー一-龠0-9]+$']);
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
        if ($action === 'add') {
            $form .= $this->Form->button(__('Register'));
        } elseif ($action === 'edit') {
            $form .= $this->Form->button(__('Edit'));
        }
        $form .= $this->Form->end();

        return $form;
    }

    //division用の登録、編集フォームのヘルパーメソッド
    public function divisionForm($data, $action)
    {
        $form = '';

        $form .= $this->Form->create($data, $action);
        $form .= $this->Form->control('division_name');
        if ($action === 'add') {
            $form .= $this->Form->button(__('Register'));
        } elseif ($action === 'edit') {
            $form .= $this->Form->button(__('Edit'));
        }
        $form .= $this->Form->end();

        return $form;
    }

    public function estimateForm($options, $requestData, $action)
    {
        $form = '';
        $form .= $this->Form->create(null);

        if ($action === 'add') {
            //見積を出す企業の選択フォーム
            $form .= $this->Form->control('corp_id', [
                'options' => $options,
                'label' => '会社を選択してください。',
                'style' => 'width: 200px',
                'required' => true,
            ]);


            $form .= '<br><br>';
            $form .= '<table cellpadding="1">';
            $form .= '<tr>';
            $form .= '<th>' . __('Tekiyo') . '</th>';
            $form .= '<th>' . __('Unit Price') . '</th>';
            $form .= '<th>' . __('Quantity') . '</th>';
            $form .= '<th>' . __('Amount') . '</th>';
            $form .= '<th>' . __('Note') . '</th>';
            $form .= '</tr>';
            $form .= '<tr>';
            $form .= '<td>' . $this->Form->text('tekiyo1', ['style' => 'width:200px', 'value' => isset($requesttData['tekiyo1']) ? $requestData['tekiyo1'] : '']) . '</td>';
            $form .= '<td>￥' . $this->Form->text('unit_price1', ['style' => 'width:85px', 'id' => 'unit_price1', 'onChange' => 'keisan()', 'value' => isset($requestData['unit_price1']) ? h($requestData['unit_price1']) : '', 'required' => true]) . '</td>';
            $form .= '<td>' . $this->Form->text('quantity1', ['style' => 'width:50px', 'id' => 'quantity1', 'onChange' => 'keisan()', 'value' => isset($requestData['quantity1']) ? h($requestData['quantity1']) : '', 'required' => true]) . '</td>';
            $form .= '<td>￥' . $this->Form->text('amount1', ['style' => 'width:100px', 'id' => 'amount1', 'readonly' => true, 'value' => isset($requestData['amount1']) ? h($requestData['amount1']) : '']) . '</td>';
            $form .= '<td>' . $this->Form->text('note1', ['style' => 'width:400px', 'value' => isset($requestData['note1']) ? h($requestData['note1']) : '']) . '</td>';
            $form .= '</tr>';

            for ($i = 2; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
                $form .= '<tr>';
                $form .= '<td>' . $this->Form->text('tekiyo' . $i, ['style' => 'width:200px', 'value' => isset($requestData['tekiyo' . $i]) ? h($requestData['tekiyo' . $i]) : '']) . '</td>';
                $form .= '<td>￥' . $this->Form->text('unit_price' . $i, ['style' => 'width:85px', 'id' => 'unit_price' . $i, 'onChange' => 'keisan()', 'value' => isset($requestData['unit_price' . $i]) ? h($requestData['unit_price' . $i]) : '']) . '</td>';
                $form .= '<td>' . $this->Form->text('quantity' . $i, ['style' => 'width:50px', 'id' => 'quantity' . $i, 'onChange' => 'keisan()', 'value' => isset($requestData['quantity' . $i]) ? h($requestData['quantity' . $i]) : '']) . '</td>';
                $form .= '<td>￥' . $this->Form->text('amount' . $i, ['style' => 'width:100px', 'id' => 'amount' . $i, 'readonly' => true, 'value' => isset($requestData['amount' . $i]) ? h($requestData['amount' . $i]) : '']) . '</td>';
                $form .= '<td>' . $this->Form->text('note' . $i, ['style' => 'width:400px', 'value' => isset($requestData['note' . $i]) ? h($requestData['note' . $i]) : '']) . '</td>';
                $form .= '</tr>';
            }

            $form .= '</table>';
            $form .= '<h3>' . __('Insert Hosoku') . '</h3>';

            for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
                $form .= $this->Form->text('hosoku' . $i, ['value' => isset($requestData['hosoku' . $i]) ? h($requestData['hosoku' . $i]) : '']);
            }
        } elseif ($action === 'edit') {
            //日付選択フォーム
            $form .= $this->Form->control('date', [
                'type' => 'date',
                'default' => $options,
                'label' => '※変更があれば日付を選択してください。',
                'style' => 'width:150px',
                'required' => true,
            ]);

            $form .= '<br><br>';
            $form .= '<table cellpadding="1">';
            $form .= '<tr>';
            $form .= '<th>' . __('Tekiyo') . '</th>';
            $form .= '<th>' . __('Unit Price') . '</th>';
            $form .= '<th>' . __('Quantity') . '</th>';
            $form .= '<th>' . __('Amount') . '</th>';
            $form .= '<th>' . __('Note') . '</th>';
            $form .= '</tr>';
            $form .= '<tr>';
            $form .= '<td>' . $this->Form->text('tekiyo1', ['style' => 'width:200px', 'value' => isset($requestData['tekiyo1']) ? $requestData['tekiyo1'] : '']) . '</td>';
            $form .= '<td>￥' . $this->Form->text('unit_price1', ['style' => 'width:85px', 'id' => 'unit_price1', 'onChange' => 'keisan()', 'value' => isset($requestData['unit_price1']) ? h($requestData['unit_price1']) : '', 'required' => true]) . '</td>';
            $form .= '<td>' . $this->Form->text('quantity1', ['style' => 'width:50px', 'id' => 'quantity1', 'onChange' => 'keisan()', 'value' => isset($requestData['quantity1']) ? h($requestData['quantity1']) : '', 'required' => true]) . '</td>';
            $form .= '<td>￥' . $this->Form->text('amount1', ['style' => 'width:100px', 'id' => 'amount1', 'readonly' => true, 'value' => isset($requestData['amount1']) ? h($requestData['amount1']) : '']) . '</td>';
            $form .= '<td>' . $this->Form->text('note1', ['style' => 'width:400px', 'value' => isset($requestData['note1']) ? h($requestData['note1']) : '']) . '</td>';
            $form .= '</tr>';

            for ($i = 2; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
                $form .= '<tr>';
                $form .= '<td>' . $this->Form->text('tekiyo' . $i, ['style' => 'width:200px', 'value' => isset($requestData['tekiyo' . $i]) ? h($requestData['tekiyo' . $i]) : '']) . '</td>';
                $form .= '<td>￥' . $this->Form->text('unit_price' . $i, ['style' => 'width:85px', 'id' => 'unit_price' . $i, 'onChange' => 'keisan()', 'value' => isset($requestData['unit_price' . $i]) ? h($requestData['unit_price' . $i]) : '']) . '</td>';
                $form .= '<td>' . $this->Form->text('quantity' . $i, ['style' => 'width:50px', 'id' => 'quantity' . $i, 'onChange' => 'keisan()', 'value' => isset($requestData['quantity' . $i]) ? h($requestData['quantity' . $i]) : '']) . '</td>';
                $form .= '<td>￥' . $this->Form->text('amount' . $i, ['style' => 'width:100px', 'id' => 'amount' . $i, 'readonly' => true, 'value' => isset($requestData['amount' . $i]) ? h($requestData['amount' . $i]) : '']) . '</td>';
                $form .= '<td>' . $this->Form->text('note' . $i, ['style' => 'width:400px', 'value' => isset($requestData['note' . $i]) ? h($requestData['note' . $i]) : '']) . '</td>';
                $form .= '</tr>';
            }

            $form .= '</table>';
            $form .= '<h3>' . __('Insert Hosoku') . '</h3>';

            for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
                $form .= $this->Form->text('hosoku' . $i, ['value' => isset($requestData['hosoku' . $i]) ? h($requestData['hosoku' . $i]) : '']);
            }
        }

        $form .= '<br><br>';
        $form .= '<div class="button">';
        $form .= $this->Form->button(__('OK'));
        $form .= '</div>';
        $form .= $this->Form->end();

        return $form;
    }
}
