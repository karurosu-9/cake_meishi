<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;



/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //ログインしていなくてもアクセスできるアクション
        $this->Authentication->addUnauthenticatedActions(['login']);
        //権限が無くてもアクセスできるアクション
        if (in_array($this->request->getParam('action'), ['login', 'logout', 'index', 'view'])) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->paginate = [
            'contain' => ['Divisions'],
            'limit' => 6,
            'order' => [
                'Users.id' => 'ASC',
            ],
        ];

        $this->Divisions = $this->getTableLocator()->get('Divisions');
        $this->loadComponent('LoginUser');
    }

    public function login()
    {
        $this->request->allowMethod(['post', 'get']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Flash->success(__('ログインしました。'));
            return $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('名前かパスワードが間違っています。もう一度やり直してください。'));
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $keyword = $this->request->getData('keyword');
        //ログインユーザーの情報を取得
        $loginUser = $this->LoginUser->getLoginUser();

        $users = $this->Users->find('all');

        if (!empty($keyword)) {
            $users = $users->where(['Users.user_name LIKE' => '%' . $keyword . '%']);
        }

        $usersCount = $users->count();

        $users = $this->paginate($users);

        $data = [
            'users' => $users,
            'usersCount' => $usersCount,
            'loginUser' => $loginUser,
        ];
        $this->set($data);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        //ログインユーザーのデータを取得
        $loginUser = $this->LoginUser->getLoginUser();

        $user = $this->Users->get($id, [
            'contain' => ['Divisions'],
        ]);

        $data = [
            'user' => $user,
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

        $user = $this->Users->newEmptyEntity();

        //ログインユーザーのadminがシステムまたは管理者でなければアクセス拒否
        if (!$this->Authorization->can($user, 'add')) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        //$divisionsにdivisionNameカラムの値を格納している
        $divisions = $this->Divisions->find('list', ['valueField' => 'division_name', 'limit' => 200])->toArray();
        $data = [
            'user' => $user,
            'divisions' => $divisions,
        ];

        $this->set($data);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);

        //ログインユーザーのadminが`システム`または管理者か、Entityの対象が自分自身でないとアクセス拒否
        if (!$this->Authorization->can($user, 'edit')) {
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Users->get($id, [
            'contain' => ['Divisions'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $divisions = $this->Divisions->find('list', ['limit' => 200, 'valueField' => 'division_name'])->toArray();

        $data = [
            'user' => $user,
            'divisions' => $divisions,
        ];

        $this->set($data);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        //ログインユーザーのadminが`システム`または管理者じゃないとアクセス拒否
        if (!$this->Authorization->can($user, 'delete')) {
            return $this->redirect(['action' => 'index']);
        }
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
