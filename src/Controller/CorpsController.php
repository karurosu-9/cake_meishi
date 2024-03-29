<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Corps Controller
 *
 * @property \App\Model\Table\CorpsTable $Corps
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorpsController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //権限が無くてもアクセスできるアクション
        if (in_array($this->request->getParam('action'), ['index', 'view'])) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Corps.corp_name' => 'ASC',
            ],
        ];

        $this->Meishi = $this->getTableLocator()->get('Meishi');
        $this->loadComponent('LoginUser');

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        //ヘルパーからログインユーザーの値を取得
        $loginUser = $this->LoginUser->getLoginUser();

        //全リストを表示させるときの処理
        $corpsList = $this->Corps->find('all');

        $searchCorpName = '';

        $keyword = '';

        //検索フォームに入力のあった時の処理
        if ($this->request->getQuery('keyword')) {
            $searchCorpName = $this->request->getQuery('keyword');
            $corpsList = $this->Corps->find()->where(['corp_name LIKE' => '%' . $searchCorpName . '%']);
        }

        $corpsCount = $corpsList->count();

        $corpsList = $this->paginate($corpsList);

        $data = [
            'corpsList' => $corpsList,
            'loginUser' => $loginUser,
            'corpsCount' => $corpsCount,
            'keyword' => $keyword,
        ];

        $this->set($data);
    }

    public function view($id = null)
    {
        $corp = $this->Corps->get($id);

        $meishiData = $this->Meishi->find('all')->where(['Meishi.corp_id' => $id])->contain(['Corps']);
        
        //検索フォームに表示する用のリスト
        $divisionsList = $this->Meishi->find('list', ['valueField' => 'division', 'limit' => '200'])->group('division')->toArray();
        $formDivisionsList = ['' => '-- 全てのデータを表示する --'] + $divisionsList;


        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Meishi.id' => 'DESC',
            ],
        ];

        $meishiData = $this->paginate($meishiData);

        $data = [
            'meishiData' => $meishiData,
            'formDivisionsList' => $formDivisionsList,
            'corp' => $corp,
        ];

        $this->set($data);
    }

    /**
     * View method
     *
     * @param string|null $id Corp id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {

        $meishiData = $this->Meishi->find('all')->where(['Meishi.corp_id' => $id])->contain(['Corps']);

        //検索フォームに表示する用のリスト
        $meishiList = $meishiData->find('list', ['valueField' => 'division', 'limit' => '200', 'distinct' => 'division'])->toArray();
        $formMeishiList = ['' => '-- 部署を選択してください。--'] + $meishiList;


        $keyword = '';

        if ($this->request->is('put')) {
            $keyword = $this->request->getData('keyword');
            $meishiData->where(['Meishi.employee_name LIKE' => '%' . $keyword . '%']);
        }

        $meishiDataCount = $meishiData->count();

        $corp = $this->Corps->get($id, [
            'contain' => ['Meishi'],
        ]);

        $this->paginate = [
            'limit' => 30,
            'order' => [
                'Meishi.id' => 'DESC',
            ],
        ];

        $meishiData = $this->paginate($meishiData);

        $data = [
            'meishiData' => $meishiData,
            'formMeishiList' => $formMeishiList,
            'meishiDataCount' => $meishiDataCount,
            'corp' => $corp,
        ];

        $this->set($data);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $corp = $this->Corps->newEmptyEntity();

        //自作関数でのアクセス権限の確認
        $this->checkPermission($corp, 'add');

        if ($this->request->is('post')) {
            $corp = $this->Corps->patchEntity($corp, $this->request->getData());
            if ($this->Corps->save($corp)) {
                $this->Flash->success(__('The corp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corp could not be saved. Please, try again.'));
        }

        $data = [
            'corp' => $corp,
        ];
        $this->set($data);
    }

    /**
     * Edit method
     *
     * @param string|null $id Corp id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $corp = $this->Corps->get($id, [
            'contain' => [],
        ]);

        //アクセス権限の確認
        $this->checkPermission($corp, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $corp = $this->Corps->patchEntity($corp, $this->request->getData());
            
            if ($this->Corps->save($corp)) {
                $this->Flash->success(__('The corp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corp could not be saved. Please, try again.'));
        }

        $data = [
            'corp' => $corp,
        ];

        $this->set($data);
    }

    /**
     * Delete method
     *
     * @param string|null $id Corp id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $corp = $this->Corps->get($id);

        //アクセス権限の確認
        $this->checkPermission($corp, 'delete');

        if ($this->Corps->delete($corp)) {
            $this->Flash->success(__('The corp has been deleted.'));
        } else {
            $this->Flash->error(__('The corp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
