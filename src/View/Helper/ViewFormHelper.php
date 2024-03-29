<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use App\Consts\EstimateConst;

/**
 * ViewForm helper
 */
class ViewFormHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->Form = $this->_View->loadHelper('Form');
    }

    //リストから選択する用のフォーム
    public function generateSearchListForm($option, $columnName, $action)
    {
        $form = '';

        $form .= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => $action]]);
        $form .= $this->Form->control($columnName, [
            'options' => h($option),
            'value' => '',
            'style' => 'width: 350px',
        ]);
        $form .= $this->Form->button(__('Search'));
        $form .= $this->Form->end();
        return $form;
    }

    //検索フォームのヘルパーメソッド ※getQuery()
    public function generateSearchQueryForm($data, $action)
    {
        $form = '';

        $form .= $this->Form->create($data, ['type' => 'get', 'url' => ['action' => $action]]);
        //文字列のみ、もしくは文字列と数字は受け付けるが、数字のみは受け付けない
        $form .= $this->Form->control('keyword', ['label' => false, 'pattern' => '^(?=.*[a-zA-Zぁ-んァ-ヶー一-龠])[a-zA-Zぁ-んァ-ヶー一-龠0-9]+$', 'style' => 'width: 350px']);
        $form .= $this->Form->button('search');
        $form .= $this->Form->end();

        return $form;
    }

    //検索フォームのヘルパーメソッド ※getData()
    public function generateSearchForm($data)
    {
        $form = '';

        $form .= $this->Form->create($data);
        //文字列のみ、もしくは文字列と数字は受け付けるが、数字のみは受け付けない仕様
        $form .= $this->Form->control('keyword', ['label' => false, 'pattern' => '^(?=.*[a-zA-Zぁ-んァ-ヶー一-龠])[a-zA-Zぁ-んァ-ヶー一-龠0-9]+$', 'style' => 'width: 350px']);
        $form .= $this->Form->button(__('Search'));
        $form .= $this->Form->end();

        return $form;
    }

    //user用の登録、編集フォームのヘルパーメソッド
    public function generateUserForm($data, $option = null, $action)
    {
        $form = '';

        $form .= $this->Form->create($data);
        if ($action === 'add' && $option !== null) {
            $form .= $this->Form->control('division_id', [
                'options' => [
                    '' => '-- 所属部署を選択してください。--',
                ] + h($option),
                'value' => '',
                'required' => true,
            ]);
            $form .= $this->Form->control('password');
        } elseif ($action === 'edit' && $option !== null) {
            $form .= $this->Form->control('division_id', [
                'options' => h($option),
                'required' => true,
            ]);
        }
        $form .= $this->Form->control('user_name');
        $form .= '<br><br>';

        //アクションボタンの変更
        if ($action === 'add') {
            $form .= $this->Form->button(__('Register'));
        } elseif ($action === 'edit') {
            $form .= $this->Form->button(__('Edit'));
        }
        $form .= $this->Form->end();

        return $form;
    }

    //corp用の登録、編集フォームのヘルパーメソッド
    public function generateCorpForm($data, $action)
    {
        $form = '';

        $form .= $this->Form->create($data);
        $form .= $this->Form->control('corp_name', [
            'style' => 'width: 300px',
            'required' => true,
        ]);
        $form .= $this->Form->control('address', [
            'style' => 'width: 300px',
            'required' => true,
        ]);
        $form .= '<br><br>';

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
    public function generateDivisionForm($data, $action)
    {
        $form = '';

        $form .= $this->Form->create($data);
        $form .= $this->Form->control('division_name', [
            'style' => 'width: 300px',
            'required' => true,
        ]);
        $form .= '<br><br>';

        //アクションに応じてボタンの表示を変更
        if ($action === 'add') {
            $form .= $this->Form->button(__('Register'));
        } elseif ($action === 'edit') {
            $form .= $this->Form->button(__('Edit'));
        }
        $form .= $this->Form->end();

        return $form;
    }

    //meishi用の登録、編集フォームのへルーパーメソッド
    public function generateMeishiForm($data, $option = null, $action)
    {
        $form = '';

        $form .= $this->Form->create($data);

        if ($action === 'add' && $option !== null) {
            $form .= $this->Form->control('corp_id', [
                'options' => [
                    '' => '-- 会社を選択してください。--',
                ] + $option,
                'value' => '',
                'label' => '会社を選択してください',
                'style' => 'width: 300px;',
                'required' => true,
            ]);
        } elseif ($action === 'edit' && $option !== null) {
            $form .= $this->control('corp_id', [
                'options' => $option,
                'label' => '会社を選択してください。',
                'style' => 'width:300px',
                'required' => true,
            ]);
        }

        $form .= '<br><br>';
        $form .= '<table>';
        $form .= '<tr>';
        $form .= '<th>' . __('division') . '</th>';
        $form .= '<th>' . __('title') . '</th>';
        $form .= '<th>' . __('employee_name') . '</th>';
        $form .= '<th>' . __('tel') . '</th>';
        $form .= '</tr>';
        $form .= '<tr>';
        $form .= '<td>' . $this->Form->text('division', ['required' => true]) . '</td>';
        $form .= '<td>' . $this->Form->text('title') . '</td>';
        $form .= '<td>' . $this->Form->text('employee_name', ['required' => true]) . '</td>';
        $form .= '<td>' . $this->Form->text('tel', ['required' => true]) . '</td>';
        $form .= '</tr>';
        $form .= '</table>';
        $form .= '<br><br>';

        //アクションに応じてボタンの表示の変更
        if ($action === 'add') {
            $form .= $this->Form->button(__('Register'));
        } elseif ($action === 'edit') {
            $form .= $this->Form->button(__('Edit'));
        }
        $form .= $this->Form->end();

        return $form;
    }

    //estimate用の登録、編集フォームのヘルパーメソッド
    public function generateEstimateForm($option = null, $requestData, $action)
    {
        $form = '';
        $form .= $this->Form->create(null);

        if ($action === 'add' && $option !== null) {
            //見積を出す企業の選択フォーム
            $form .= $this->Form->control('corp_id', [
                'options' => [
                    'value' => '-- 会社を選択してください。--',
                ] + $option,
                'value' => '',
                'label' => '会社を選択してください。',
                'style' => 'width: 300px',
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
        } elseif ($action === 'edit' && $option !== null) {
            //日付選択フォーム
            $form .= $this->Form->control('date', [
                'type' => 'date',
                'default' => $option,
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

        //アクションに応じてボタンの表示の変更
        if ($action === 'add') {
            $form .= '<div class="button">';
            $form .= $this->Form->button(__('Register'));
            $form .= '</div>';
        } elseif ($action === 'edit') {
            $form .= '<div class="button">';
            $form .= $this->Form->button(__('Edit'));
            $form .= '</div>';
        }
        $form .= $this->Form->end();

        return $form;
    }
}
