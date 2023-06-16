<?php

declare(strict_types=1);

namespace App\Controller;

use App\Consts\EstimateConst;
use Cake\Routing\Route\RedirectRoute;

/**
 * Estimates Controller
 *
 * @property \App\Model\Table\EstimatesTable $Estimates
 * @method \App\Model\Entity\Estimate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstimatesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        //登録企業の情報を取得
        $this->Corps = $this->getTableLocator()->get('Corps');

        //自社の情報を取得
        $this->MyCorps = $this->getTableLocator()->get('MyCorps');

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'created' => 'DESC',
            ],
        ];
    }

    /*public function index()
   {
    // アクセス時は見積データを表示しない状態にする
    $estimatesCount = 0;
    $estimates = [];

    // 会社名で検索をかけた時に取得する値
    $corpId = $this->request->getData('corp_id');


    // 会社名の選択肢を取得
    $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name']);
    //セッション用のタイマーの初期値
    $time = 0;

    // 検索フォームが送信された場合
    if ($this->request->is('post') && $corpId) {
        $time = time() + (5 * 60);
        // 検索条件と制限時間をセッションに保存
        $searchId = $this->request->getData();
        $this->request->getSession()->write('Estimates.search', [
            'corp_id' => $searchId,
            'time' => $time
        ]);
    }

    // セッションから検索条件と制限時間をそれぞれ分けて取得
    $searchData = $this->request->getSession()->read('Estimates.search');
    $searchId = isset($searchData['corp_id']) ? $searchData['corp_id'] : [];
    $searchTime = isset($searchData['time']) ? $searchData['time'] : null;

    // 制限時間が設定されていて、現在の時刻が制限時間を超えている場合、セッションを削除して検索条件をクリア
    if ($searchTime && $searchTime < time()) {
        $this->request->getSession()->delete('Estimates.search');
        $searchId = [];
    }

    // 検索条件がある場合
    if ($searchId) {
        $estimates = $this->Estimates->find('all')->contain(['Corps']);
        $estimates = $estimates->where(['corp_id' => $searchId['corp_id']]);
        $estimatesCount = $estimates->count();
        $estimates = $this->paginate($estimates);
    }

    $data = [
        'corps' => $corps,
        'estimates' => $estimates,
        'estimatesCount' => $estimatesCount,
    ];

    $this->set($data);
   }*/

   //getQueryのindex
   /*public function index()
   {

    $loginUser = $this->Authentication->getResult()->getData();

    // アクセス時は見積データを表示しない状態にする
    $estimatesCount = 0;
    $estimates = [];

    // 会社名で検索をかけた時に取得する値
    $corpId = $this->request->getQuery('corp_id');

    // 会社名の選択肢を取得
    $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name']);

    $time = 0;

    // 検索フォームが送信された場合
    if ($this->request->is('get') && $corpId) {
        $time = time() + (10 * 60);
        // 検索条件と制限時間をセッションに保存
        $searchParams = $this->request->getQueryParams();
        $this->request->getSession()->write('Estimates.search', [
            'params' => $searchParams,
            'time' => $time
        ]);
    } elseif ($this->request->getQuery('clear')) {
        // クエリパラメータ "clear" が指定された場合、セッションを削除して検索条件をクリア
        $this->request->getSession()->delete('Estimates.search');
    }

    // セッションから検索条件と制限時間を取得
    $searchData = $this->request->getSession()->read('Estimates.search');
    $searchParams = isset($searchData['params']) ? $searchData['params'] : [];
    $searchTime = isset($searchData['time']) ? $searchData['time'] : null;

    // 制限時間が設定されていて、現在の時刻が制限時間を超えている場合、セッションを削除して検索条件をクリア
    if ($searchTime && $searchTime < time()) {
        $this->request->getSession()->delete('Estimates.search');
        $searchParams = [];
    }

    // 検索条件がある場合
    if ($searchParams) {
        $estimates = $this->Estimates->find('all')->contain(['Corps']);
        $estimates = $estimates->where(['corp_id' => $searchParams['corp_id']]);
        $estimatesCount = $estimates->count();
        $estimates = $this->paginate($estimates);
    }

    $data = [
        'corps' => $corps,
        'estimates' => $estimates,
        'estimatesCount' => $estimatesCount,
        'searchParams' => $searchParams,
        'loginUser' => $loginUser,
    ];

    $this->set($data);
   }*/


   public function index()
    {

        $loginUser = $this->Authentication->getResult()->getData();

        // アクセス時は見積データを表示しない状態にする
        $estimatesCount = 0;
        $estimates = [];


        // 会社名の選択肢を取得
        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name']);
        //セッション用のタイマーの初期値
        $time = 0;

        // 会社名で検索をかけた時に取得する値
        $corpId = $this->request->getData('corp_id');

        // 検索フォームが送信された場合
        if ($this->request->is('post') && $corpId) {
            $time = time() + (5 * 60);
            // 検索条件と制限時間をセッションに保存
            $searchId = $this->request->getData();
            $this->request->getSession()->write('Estimates.search', [
                'corp_id' => $searchId,
                'time' => $time
            ]);
        }

        // セッションから検索条件と制限時間をそれぞれ分けて取得
        $searchData = $this->request->getSession()->read('Estimates.search');
        $searchId = isset($searchData['corp_id']) ? $searchData['corp_id'] : [];
        $searchTime = isset($searchData['time']) ? $searchData['time'] : null;

        // 制限時間が設定されていて、現在の時刻が制限時間を超えている場合、セッションを削除して検索条件をクリア
        if ($searchTime && $searchTime < time()) {
            $this->request->getSession()->delete('Estimates.search');
            $searchId = [];
        }

        // 検索条件がある場合
        if ($searchId) {
            $estimates = $this->Estimates->find('all')->contain(['Corps']);
            $estimates = $estimates->where(['corp_id' => $searchId['corp_id']]);
            $estimatesCount = $estimates->count();
            $estimates = $this->paginate($estimates);
        }

        $data = [
            'loginUser' => $loginUser,
            'corps' => $corps,
            'estimates' => $estimates,
            'estimatesCount' => $estimatesCount,
        ];

        $this->set($data);
    }



//バックアップデータ
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    /*public function index()
    {

        $loginUser = $this->Authentication->getResult()->getData();

        // アクセス時は見積データを表示しない状態にする
        $estimatesCount = 0;
        $estimates = [];


        // 会社名の選択肢を取得
        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name']);
        //セッション用のタイマーの初期値
        $time = 0;

        // 会社名で検索をかけた時に取得する値
        $corpId = $this->request->getData('corp_id');

        // 検索フォームが送信された場合
        if ($this->request->is('post') && $corpId) {
            $time = time() + (5 * 60);
            // 検索条件と制限時間をセッションに保存
            $searchId = $this->request->getData();
            $this->request->getSession()->write('Estimates.search', [
                'corp_id' => $searchId,
                'time' => $time
            ]);
        }

        // セッションから検索条件と制限時間をそれぞれ分けて取得
        $searchData = $this->request->getSession()->read('Estimates.search');
        $searchId = isset($searchData['corp_id']) ? $searchData['corp_id'] : [];
        $searchTime = isset($searchData['time']) ? $searchData['time'] : null;

        // 制限時間が設定されていて、現在の時刻が制限時間を超えている場合、セッションを削除して検索条件をクリア
        if ($searchTime && $searchTime < time()) {
            $this->request->getSession()->delete('Estimates.search');
            $searchId = [];
        }

        // 検索条件がある場合
        if ($searchId) {
            $estimates = $this->Estimates->find('all')->contain(['Corps']);
            $estimates = $estimates->where(['corp_id' => $searchId['corp_id']]);
            $estimatesCount = $estimates->count();
            $estimates = $this->paginate($estimates);
        }

        $data = [
            'loginUser' => $loginUser,
            'corps' => $corps,
            'estimates' => $estimates,
            'estimatesCount' => $estimatesCount,
        ];

        $this->set($data);
    }*/

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

        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name'])->all();

        //入力したフォームデータの内容をaddアクションで登録せずへ格納して見積確認フォームへリダイレクトする
        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            //confirmEstimateアクションで新規作成時と編集時の日付を区別する為、空を格納する
            $postData['date'] = '';
            $this->request->getSession()->write('postData', $postData);
            return $this->redirect(['action' => 'confirmEstimate']);
        }

        $data = [
            'corps' => $corps,
        ];

        $this->set($data);
    }


    public function confirmEstimate()
    {
        $postData = $this->request->getSession()->read('postData');

        $loginUser = $this->Authentication->getResult()->getData();

        $estimate = $this->Estimates->newEmptyEntity();

        //新規で作成の場合、現在の年月日の取得
        if (!empty($postData['date'])) {
            //データベースに登録する形式の日付
            $estimateDate = $postData['date'];
            //ビューに表示する形式に変換
            $unixDate = strtotime($estimateDate);
            $formattedDate = date('Y年n月j日', $unixDate);
        } else {
            $estimateDate = date('Y-m-d');
            //ビューに表示する形式に変換
            $unixDate = strtotime($estimateDate);
            $formattedDate = date('Y年n月j日', $unixDate);
        }



        //会社のIDを取得
        $corp_id = $postData['corp_id'];

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

    /*public function confirmEstimate()
    {

        $loginUser = $this->Authentication->getResult()->getData();

        $estimate = $this->Estimates->newEmptyEntity();


        //年月日の取得
        $year = date('Y');
        $month = date('n');
        $date = date('d');

        //見積作成時の日付を"-"の表示から年月日の表示にする
        $currentDate = $year . '年' . $month . '月' . $date . '日';

        $corpData = $this->Corps->find();
        $corp_id = $this->request->getSession()->read('postData.corp_id');
        $corp = $corpData->where(['id' => $corp_id])->first();

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


        //postで飛んできた値を取得
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
            $postData = $this->request->getSession()->read('postData');
            $estimate = $this->Estimates->patchEntity($estimate, $postData);
            $estimate['total_amount'] = $totalAmount;
            $estimate['date'] = $currentDate;
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
            'currentDate' => $currentDate,
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
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {


        $estimate = $this->Estimates->get($id, [
            'contain' => ['Corps'],
        ]);



        //editアクションで登録はせずに見積確認フォームにリダイレクトする
        if ($this->request->is('post', 'put', 'patch')) {
            $estimateData = $this->request->getData();
            $estimateData['corp_id'] = $estimate->corp->id;
            $this->request->getSession()->write('postData', $estimateData);
            $estimateData = $this->request->getSession()->read('postData');
            return $this->redirect(['action' => 'ConfirmEstimate']);
        }

        $data = [
            'estimate' => $estimate,
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
}
