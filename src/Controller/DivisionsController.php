<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\Query;
use Cake\Event\EventInterface;

/**
 * Divisions Controller
 *
 * @property \App\Model\Table\DivisionsTable $Divisions
 * @method \App\Model\Entity\Division[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DivisionsController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {

        //権限が無くてもアクセスできるアクション
        if (in_array($this->request->getParam('action'), ['index', 'view'])) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function initialize(): void
    {
        parent::initialize();
        
        $this->Users = $this->getTableLocator()->get('Users');
        $this->loadComponent('LoginUser');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $divisions = $this->Divisions->find('all');

        $loginUser = $this->LoginUser->getLoginUser();

        $keyword = '';

        if ($this->request->is('put')) {
            $keyword = $this->request->getData('keyword');
            $divisions->where(['Divisions.division_name LIKE' => '%' . $keyword . '%']);
        }

        $divisionsCount = $divisions->count();

        $divisions = $this->paginate($divisions);

        $data = [
            'divisions' => $divisions,
            'divisionsCount' => $divisionsCount,
            'loginUser' => $loginUser,
        ];

        $this->set($data);
    }

    /**
     * View method
     *
     * @param string|null $id Division id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $division = $this->Divisions->get($id, [
            'contain' => ['Users'],
        ]);

        //ログインユーザーのデータを取得
        $loginUser = $this->LoginUser->getLoginUser();

        //userテーブルからdivisionsのidに紐づいたユーザーを取得
        $users = $this->Users->find('all')->where(['Users.division_id' => $id]);

        $this->paginate = [
            'limit' => 10,
            'contain' => ['Divisions'],
            'order' => [
                'Users.id' => 'ASC',
            ],
        ];

        $users = $this->paginate($users);

        $data = [
            'division' => $division,
            'users' => $users,
            'loginUser' => $loginUser,
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
        $division = $this->Divisions->newEmptyEntity();

        //自作関数でのアクセスの権限の確認
        $this->checkPermission($division, 'add');

        if ($this->request->is('post')) {
            $division = $this->Divisions->patchEntity($division, $this->request->getData());
            if ($this->Divisions->save($division)) {
                $this->Flash->success(__('The division has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The division could not be saved. Please, try again.'));
        }

        $data = [
            'division' => $division,
        ];

        $this->set($data);
    }

    /**
     * Edit method
     *
     * @param string|null $id Division id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $division = $this->Divisions->get($id, [
            'contain' => [],
        ]);

        //アクセス権限の確認
        $this->checkPermission($division, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $division = $this->Divisions->patchEntity($division, $this->request->getData());
            if ($this->Divisions->save($division)) {
                $this->Flash->success(__('The division has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The division could not be saved. Please, try again.'));
        }

        $data = [
            'division' => $division,
        ];

        $this->set($data);
    }

    /**
     * Delete method
     *
     * @param string|null $id Division id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $division = $this->Divisions->get($id);

        //アクセス権限の確認
        $this->checkPermission($division, 'delete');

        if ($this->Divisions->delete($division)) {
            $this->Flash->success(__('The division has been deleted.'));
        } else {
            $this->Flash->error(__('The division could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
