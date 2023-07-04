<?php

declare(strict_types=1);

namespace App\Controller;

use App\Consts\EstimateConst;
use Cake\Routing\Route\RedirectRoute;
use Cake\Event\EventInterface;

/**
 * Estimates Controller
 *
 * @property \App\Model\Table\EstimatesTable $Estimates
 * @method \App\Model\Entity\Estimate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstimatesController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //権限が無くてもアクセスできるアクション
        if (in_array($this->request->getParam('action'), ['index', 'view', 'delete'])) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function initialize(): void
    {
        parent::initialize();
        //登録企業の情報を取得
        $this->Corps = $this->getTableLocator()->get('Corps');

        //自社の情報を取得
        $this->MyCorps = $this->getTableLocator()->get('MyCorps');
        
        $this->loadComponent('LoginUser');

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'created' => 'DESC',
            ],
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $loginUser = $this->LoginUser->getLoginUser();

        //アクセス時は見積データを表示しない状態にする
        $estimatesCount = 0;

        //選択肢を会社名にして、デフォルト値を設定
        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name'])->all();
        $options = ['' => '---  選択リスト  ---'] + $corps->toArray();

        $corp = [];
        $estimates = [];
        $formattedDates = [];

        //検索をかけた時の処理
        if ($this->request->getQuery('corp_id')) {
            $searchId = $this->request->getQuery('corp_id');
            $corp = $this->Corps->find()->select('corp_name')->where(['id' => $searchId])->first();
            $estimates = $this->Estimates->find('all')->contain(['Corps']);
            $estimates = $estimates->where(['corp_id' => $searchId]);
            $estimatesCount = $estimates->count();
            $estimates = $this->paginate($estimates);

            foreach ($estimates as $estimate) {
                $date = $estimate->date;
                if (!empty($date)) {
                    $unixDate = strtotime($date);
                    $formattedDate = date('Y年n月j日', $unixDate);
                    $formattedDates[] = $formattedDate;
                }
            }
        }

        $data = [
            'loginUser' => $loginUser,
            'options' => $options,
            'corp' => $corp,
            'estimates' => $estimates,
            'estimatesCount' => $estimatesCount,
            'formattedDates' => $formattedDates,
        ];

        $this->set($data);
    }


    /**
     * View method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        $estimate = $this->Estimates->get($id, [
            'contain' => ['Corps'],
        ]);

        $date = $estimate->date;
        //ビューに表示する日付の形式を変更
        $unixDate = strtotime($date);
        $formattedDate = date('Y年n月j日', $unixDate);

        $corp = $this->Corps->find()->where(['id' => $estimate->corp_id])->first();

        //自社情報取得
        $myCorp = $this->MyCorps->find()->first();
        $myCorpName = $myCorp->corp;
        //表示形式の変更
        $postCode = substr($myCorp->post_code, 0, 3) . '-' . substr($myCorp->post_code, 3);
        $address = $myCorp->address;
        //表示形式の変更
        $tel = substr($myCorp->tel, 0, 3) . '-' . substr($myCorp->tel, 3, 3) . '-' . substr($myCorp->tel, 6);
        $fax = substr($myCorp->fax, 0, 3) . '-' . substr($myCorp->fax, 3, 3) . '-' . substr($myCorp->fax, 6);
        $place = $myCorp->place;
        $conditions = $myCorp->conditions;
        $deadline = $myCorp->deadline;

        //自作関数から見積データの取得
        $result = $this->processEstimateData($id);

        $tekiyo = $result['tekiyo'];
        $unitPrice = $result['unit_price'];
        $quantity = $result['quantity'];
        $amount = $result['amount'];
        $note = $result['note'];
        $totalAmount = $result['total_amount'];
        $hosoku = $result['hosoku'];

        $data = [
            'estimate' => $estimate,
            'formattedDate' => $formattedDate,
            'corp' => $corp,
            'myCorpName' => $myCorpName,
            'postCode' => $postCode,
            'address' => $address,
            'tel' => $tel,
            'fax' => $fax,
            'place' => $place,
            'conditions' => $conditions,
            'deadline' => $deadline,
            'tekiyo' => $tekiyo,
            'unitPrice' => $unitPrice,
            'quantity' => $quantity,
            'amount' => $amount,
            'note' => $note,
            'totalAmount' => $totalAmount,
            'hosoku' => $hosoku,
        ];

        $this->set($data);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //アクセス制限の確認
        $estimate = $this->Estimates->newEmptyEntity();
        $this->checkPermission($estimate, 'add');
        $postData = [];
        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name'])->all();
        $options = ['' => '---  会社を選択してください。 ---'] + $corps->toArray();

        //入力したフォームデータの内容をaddアクションで登録せず格納して見積確認フォームへリダイレクトする
        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            //confirmEstimateアクションで新規作成時と編集時の日付を区別する為、空を格納する
            $postData['date'] = '';
            $this->request->getSession()->write('postData', $postData);
            return $this->redirect(['action' => 'confirmEstimate']);
        }

        $data = [
            'postData' => $postData,
            'options' => $options,
        ];

        $this->set($data);
    }


    public function confirmEstimate()
    {
        //アクセス制限の確認
        $estimate = $this->Estimates->newEmptyEntity();
        $this->checkPermission($estimate, 'confirmEstimate');

        $postData = $this->request->getSession()->read('postData');

        $loginUser = $this->LoginUser->getLoginUser();

        //新規作成用のデータを入れるのか編集用のデータなのかを区別
        if (!empty($postData['id'])) {
            $estimate = $this->Estimates->find()->where(['id' => $postData['id']])->first();
        } else {
            $estimate = $this->Estimates->newEmptyEntity();
        }

        //編集の場合は、現在の年月日もしくはユーザーの指定した年月日、新規作成の場合は、現在の年月日の取得
        if (!empty($postData['date'])) {
            //テーブルに登録する形式の日付
            $estimateDate = $postData['date'];
            //ビューに表示する形式に変換
            $unixDate = strtotime($estimateDate);
            $formattedDate = date('Y年n月j日', $unixDate);
        } else {
            //テーブルに登録する形式の日付
            $estimateDate = date('Y-m-d');
            //ビューに表示する形式に変換
            $unixDate = strtotime($estimateDate);
            $formattedDate = date('Y年n月j日', $unixDate);
        }



        //会社のIDを取得
        $corp_id = $postData['corp_id'];
        //IDから関連する会社情報の取得
        $corpData = $this->Corps->find();
        $corp = $corpData->where(['id' => $corp_id])->first();

        //自社情報の取得
        $myCorp = $this->MyCorps->find()->first();

        //郵便番号をハイフン有りで出力する
        $postCode = substr($myCorp->post_code, 0, 3) . '-' . substr($myCorp->post_code, 3);

        //電話番号をハイフン有りで出力する
        $tel = substr($myCorp->tel, 0, 3) . '-' . substr($myCorp->tel, 3, 3) . '-' . substr($myCorp->tel, 6);

        //FAX番号をハイフン有りで出力する
        $fax = substr($myCorp->fax, 0, 3) . '-' . substr($myCorp->fax, 3, 3) . '-' . substr($myCorp->fax, 6);

        $address = $myCorp->address;
        $myCorpName = $myCorp->corp;
        $place = $myCorp->place;
        $conditions = $myCorp->conditions;
        $deadline = $myCorp->deadline;


        //自作関数から見積データの取得
        $result = $this->processEstimateData();

        //postで飛んできた値を変数へ格納
        $tekiyo = $result['tekiyo'];
        $unitPrice = $result['unit_price'];
        $quantity = $result['quantity'];
        $amount = $result['amount'];
        $note = $result['note'];
        $totalAmount = $result['total_amount'];
        $hosoku = $result['hosoku'];

        //フォームの内容がOKであった場合のpostLinkボタンを押された時の処理
        if ($this->request->is('post')) {
            //sessionへ格納されたフォームの値を$postDataへ格納
            $estimate = $this->Estimates->patchEntity($estimate, $postData);
            $estimate['total_amount'] = $totalAmount;
            $estimate['date'] = $estimateDate;
            $estimate['create_user'] = $loginUser->user_name;
            if ($this->Estimates->save($estimate)) {
                $this->Flash->success(__('見積データを登録しました。'));
                $this->request->getSession()->delete('postData');
                return $this->redirect(['action' => 'view', $estimate->id]);
            } else {
                $this->Flash->error(__('見積データの登録に失敗しました。もう一度確認してやり直してください。'));
            }
        }

        $data = [
            'estimate' => $estimate,
            'estimateDate' => $estimateDate,
            'formattedDate' => $formattedDate,
            'corp' => $corp,
            'postCode' => $postCode,
            'tel' => $tel,
            'fax' => $fax,
            'address' => $address,
            'myCorpName' => $myCorpName,
            'place' => $place,
            'conditions' => $conditions,
            'deadline' => $deadline,
            'tekiyo' => $tekiyo,
            'unitPrice' => $unitPrice,
            'quantity' => $quantity,
            'amount' => $amount,
            'note' => $note,
            'totalAmount' => $totalAmount,
            'hosoku' => $hosoku,
        ];

        $this->set($data);
    }


    /**
     * Edit method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //アクセス制限の確認
        $estimateEntity = $this->Estimates->newEmptyEntity();
        $this->checkPermission($estimateEntity, 'edit');
         
        $estimate = $this->Estimates->get($id, [
            'contain' => ['Corps'],
        ]);

        $estimateDate = $estimate->date;

        //editアクションで登録はせずに見積確認フォームにリダイレクトする
        if ($this->request->is('post', 'put', 'patch')) {
            $estimateData = $this->request->getData();
            $estimateData['id'] = $estimate->id;
            $estimateData['corp_id'] = $estimate->corp->id;
            $this->request->getSession()->write('postData', $estimateData);
            return $this->redirect(['action' => 'ConfirmEstimate']);
        }

        $data = [
            'estimate' => $estimate,
            'estimateDate' => $estimateDate,
        ];

        $this->set($data);
    }


    /**
     * Delete method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $estimate = $this->Estimates->get($id);
        if ($this->Estimates->delete($estimate)) {
            $this->Flash->success(__('The estimate has been deleted.'));
        } else {
            $this->Flash->error(__('The estimate could not be deleted. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'index']);
    }

    private function processEstimateData($id = null)
    {
        $tekiyo = [];
        $unitPrice = [];
        $quantity = [];
        $amount = [];
        $note = [];
        $hosoku = [];
        $totalAmount = 0;

        //confirmEstimateアクション時はセッションから値を取得する時の処理
        if ($this->request->getSession()->read('postData')) {

            $postData = $this->request->getSession()->read('postData');

            for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
                $tekiyo[$i] = $postData['tekiyo' . $i];
                $unitPrice[$i] = $postData['unit_price' . $i];
                $quantity[$i] = $postData['quantity' . $i];
                $amount[$i] = $postData['amount' . $i];
                $note[$i] = $postData['note' . $i];
                $totalAmount += (int)$amount[$i];
            }


            for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
                $hosoku[$i] = $postData['hosoku' . $i];
            }


            return [
                'tekiyo' => $tekiyo,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'amount' => $amount,
                'note' => $note,
                'hosoku' => $hosoku,
                'total_amount' => $totalAmount,
            ];
            //view, editアクション時はデータベースから値を取得する
        } else {
            $estimate = $this->Estimates->find()->where(['id' => $id])->first()->toArray();

            for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
                $tekiyo[$i] = $estimate['tekiyo' . $i];
                $unitPrice[$i] = $estimate['unit_price' . $i];
                $quantity[$i] = $estimate['quantity' . $i];
                $amount[$i] = $estimate['amount' . $i];
                $note[$i] = $estimate['note' . $i];
                $totalAmount += (int)$amount[$i];
            }

            for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
                $hosoku[$i] = $estimate['hosoku' . $i];
            }

            return [
                'tekiyo' => $tekiyo,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'amount' => $amount,
                'note' => $note,
                'hosoku' => $hosoku,
                'total_amount' => $totalAmount,
            ];
        }
    }

    // *********************************バックアップデータ*****************************************
    /*private function processEstimateData($id = null)
    {
        $tekiyo = [];
        $unitPrice = [];
        $quantity = [];
        $amount = [];
        $note = [];
        $hosoku = [];
        $totalAmount = 0;

        //セッションから値を取得する時の処理
        if ($this->request->getSession()->read('postData')) {

            $postData = $this->request->getSession()->read('postData');

            for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
                $tekiyo[$i] = $postData['tekiyo' . $i];
                $unitPrice[$i] = $postData['unit_price' . $i];
                $quantity[$i] = $postData['quantity' . $i];
                $amount[$i] = $postData['amount' . $i];
                $note[$i] = $postData['note' . $i];
                $totalAmount += (int)$amount[$i];
            }


            for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
                $hosoku[$i] = $postData['hosoku' . $i];
            }


            return [
                'tekiyo' => $tekiyo,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'amount' => $amount,
                'note' => $note,
                'hosoku' => $hosoku,
                'total_amount' => $totalAmount,
            ];
            //テーブルから値を取得する
        } else {
            $estimate = $this->Estimates->find()->where(['id' => $id])->first()->toArray();

            for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
                $tekiyo[$i] = $estimate['tekiyo' . $i];
                $unitPrice[$i] = $estimate['unit_price' . $i];
                $quantity[$i] = $estimate['quantity' . $i];
                $amount[$i] = $estimate['amount' . $i];
                $note[$i] = $estimate['note' . $i];
                $totalAmount += (int)$amount[$i];
            }

            for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
                $hosoku[$i] = $estimate['hosoku' . $i];
            }

            return [
                'tekiyo' => $tekiyo,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'amount' => $amount,
                'note' => $note,
                'hosoku' => $hosoku,
                'total_amount' => $totalAmount,
            ];
        }
    }*/
}
