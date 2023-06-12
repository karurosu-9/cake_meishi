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
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Corps'],
        ];
        $estimates = $this->paginate($this->Estimates);

        $this->set(compact('estimates'));
    }

    /**
     * View method
     *
     * @param string|null $id Estimate id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estimate = $this->Estimates->get($id, [
            'contain' => ['Corps'],
        ]);

        $date = $estimate->date;

        $corp = $this->Corps->find()->where(['id' => $estimate->corp_id])->first();

        //自社情報取得
        $myCorp = $this->MyCorps->find()->first();
        $myCorpName = $myCorp->corp;
        $postCode = substr($myCorp->post_code, 0, 3) . '-' . substr($myCorp->post_code, 3);
        $address = $myCorp->address;
        $tel = substr($myCorp->tel, 0, 3) . '-' . substr($myCorp->tel, 3, 3) . '-' . substr($myCorp->tel, 6);
        $fax = substr($myCorp->fax, 0, 3) . '-' . substr($myCorp->fax, 3, 3) . '-' . substr($myCorp->fax, 6);
        $place = $myCorp->place;
        $conditions = $myCorp->conditions;
        $deadline = $myCorp->deadline;



        $data = [
            'estimate' => $estimate,
            'date' => $date,
            'corp' => $corp,
            'myCorpName' => $myCorpName,
            'postCode' => $postCode,
            'address' => $address,
            'tel' => $tel,
            'fax' => $fax,
            'place' => $place,
            'conditions' => $conditions,
            'deadline' => $deadline,
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

        //入力したフォームデータの内容をsessionへ格納してconfirmEstimateアクションへ渡す
        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            $this->request->getSession()->write('postData', $postData);
            return $this->redirect(['action' => 'confirmEstimate']);
        }

        $data = [
            'corps' => $corps,
        ];

        $this->set($data);
    }

    /*public function confirmEstimate()
    {
        //年月日の取得
        $year = date('Y');
        $month = date('n');
        $date = date('d');

        //見積作成時の日付を"-"の表示から年月日の表示にする
        $currentDate = $year . '年' . $month . '月' . $date . '日';

        $corp = $this->Corps->find();
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

        if ($this->request->is('post')) {

            $postData = $this->request->getData();
            //post送信されたフォームの値をセッションへ格納
            $this->request->getSession()->write('postData', $postData);

            $corp = $corp->where(['id' => $this->request->getData('corp_id')])->first();

            //postで飛んできた値を取得
            $result = $this->processEstimateData();

            //postで飛んできた値を変数へ格納
            $tekiyo = $result['tekiyo'];
            $unitPrice = $result['unit_price'];
            $quantity = $result['quantity'];
            $amount = $result['amount'];
            $note = $result['note'];
            $totalAmount = number_format($result['totalAmount']);
            $hosoku = $result['hosoku'];
        }

        $data = [
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

    public function confirmEstimate()
    {

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
        $totalAmount = number_format($result['totalAmount']);
        $hosoku = $result['hosoku'];

        //フォームの内容がOKであった場合のpostLinkボタンを押された時の処理
        if ($this->request->is('post')) {
            //sessionへ格納されたフォームの値を$postDataへ格納
            $postData = $this->request->getSession()->read('postData');
            //var_dump($postData);exit;
            $estimate = $this->Estimates->patchEntity($estimate, $postData);
            $estimate['total_amount'] = (int)$totalAmount;
            $estimate['date'] = $currentDate;
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
        $estimate = $this->Estimates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estimate = $this->Estimates->patchEntity($estimate, $this->request->getData());
            if ($this->Estimates->save($estimate)) {
                $this->Flash->success(__('The estimate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estimate could not be saved. Please, try again.'));
        }
        $corps = $this->Estimates->Corps->find('list', ['limit' => 200])->all();
        $this->set(compact('estimate', 'corps'));
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
        }

        return $this->redirect(['action' => 'index']);
    }

    private function processEstimateData()
    {
        $postData = $this->request->getSession()->read('postData');

        $tekiyo = [];
        $unitPrice = [];
        $quantity = [];
        $amount = [];
        $note = [];
        $hosoku = [];
        $totalAmount = 0;

        for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
            $tekiyo[$i] = $postData['tekiyo' . $i];
            $unitPrice[$i] = $postData['unit_price' . $i];
            $quantity[$i] = $postData['quantity' . $i];
            $amount[$i] = $postData['amount' . $i];
            $note[$i] = $postData['note' . $i];
        }

        for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
            $hosoku[$i] = $this->request->getData('hosoku' . $i);
        }

        for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
            $totalAmount += (int)$amount[$i];
        }

        $formattedUnitPrice = [];
        $i = 1;

        foreach ($unitPrice as $price) {
            $formattedUnitPrice[$i] = number_format((int)$price);
            $i++;
        }


        return [
            'tekiyo' => $tekiyo,
            'unit_price' => $formattedUnitPrice,
            'quantity' => $quantity,
            'amount' => $amount,
            'note' => $note,
            'hosoku' => $hosoku,
            'totalAmount' => $totalAmount,
        ];
    }
}
