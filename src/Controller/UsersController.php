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

    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //ログインしていなくてもアクセスできるアクション
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login()
    {
            $this->request->allowMethod(['post', 'get']);
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {
                $this->Flash->success(__('ログインしました。'));
                return $this->redirect(['controller' => 'Users', 'action' => 'index']);
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
        $loginUser = $this->Authentication->getResult()->getData();

        $users = $this->Users->find('all');

        if (!empty($keyword)) {
            $users = $this->Users->find()->where(['Users.userName LIKE' => '%' . $keyword . '%']);
        }

        $users = $this->paginate($users);

        $data = [
            'users' => $users,
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
    public function view($id = null)
    {
        //ログインユーザーのデータを取得
        $loginUser = $this->Authentication->getResult()->getData();

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
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        //$divisionsにdivisionNameカラムの値を格納している
        $divisions = $this->Divisions->find('list', ['valueField' => 'divisionName', 'limit' => 200])->toArray();
        $data =[
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
        $divisions = $this->Divisions->find('list', ['limit' => 200, 'valueField' => 'divisionName'])->toArray();

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
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
