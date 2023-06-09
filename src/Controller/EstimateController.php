<?php
declare(strict_types=1);

namespace App\Controller;

use App\Consts\EstimateConst;

/**
 * Estimate Controller
 *
 * @property \App\Model\Table\EstimateTable $Estimate
 * @method \App\Model\Entity\Estimate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstimateController extends AppController
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
        $estimate = $this->paginate($this->Estimate);

        $this->set(compact('estimate'));
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
        $estimate = $this->Estimate->get($id, [
            'contain' => ['Corps'],
        ]);

        $this->set(compact('estimate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name'])->all();

        $data = [
            'corps' => $corps,
        ];
        $this->set($data);
    }

    public function confirmEstimate()
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
    }

    public function resultEstimate()
    {

        //セッションに格納されたフォームの値を$postDataへ格納
        $postData = $this->request->getSession()->read('postData');
        //セッションに格納された値を削除
        $this->request->getSession()->delete('postData');

        $estimate = $this->Estimate->newEmptyEntity();
        if ($this->request->is('post')) {
            $estimate = $this->Estimate->patchEntity($estimate, $postData);

            if ($this->Estimate->save($estimate)) {
                $this->Flash->success(__('The estimate has been saved.'));

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error(__('The estimate could not be saved. Please, try again.'));
        }
        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name'])->all();
        $this->set(compact('estimate', 'corps'));
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
        $estimate = $this->Estimate->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $estimate = $this->Estimate->patchEntity($estimate, $this->request->getData());
            if ($this->Estimate->save($estimate)) {
                $this->Flash->success(__('The estimate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The estimate could not be saved. Please, try again.'));
        }
        $corps = $this->Estimate->Corps->find('list', ['limit' => 200])->all();
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
        $estimate = $this->Estimate->get($id);
        if ($this->Estimate->delete($estimate)) {
            $this->Flash->success(__('The estimate has been deleted.'));
        } else {
            $this->Flash->error(__('The estimate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function processEstimateData() {
        $tekiyo = [];
        $unitPrice = [];
        $quantity = [];
        $amount = [];
        $note = [];
        $hosoku = [];
        $totalAmount = 0;

        for ($i = 1; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
            $tekiyo[$i] = $this->request->getData('tekiyo' . $i);
            $unitPrice[$i] = $this->request->getData('unit_price' . $i);
            $quantity[$i] = $this->request->getData('quantity' . $i);
            $amount[$i] = $this->request->getData('amount' . $i);
            $note[$i] = $this->request->getData('note' . $i);
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
