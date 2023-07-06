<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use App\Controller\AppController;



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
        //ログインユーザーの値を取得するコンポーネント
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
        $userFormData = [];

        //アクセス権限の確認)(AppControllerからの関数)
        $user = $this->Users->newEmptyEntity();
        $this->checkPermission($user, 'add');

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $userFormData = $this->request->getData();
            
            //自作関数からadminの値を取得
            $user->admin = $this->selectAdmin($userFormData);
            
            $user = $this->Users->patchEntity($user, $userFormData);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        //$divisionsにdivisionNameカラムの値を格納している
        $divisions = $this->Divisions->find('list', ['valueField' => 'division_name', 'limit' => 200])->order(['id' => 'ASC'])->toArray();

        //フォームの選択リストに表示しないものを設定
        $divisionsList = [];
        $excludeDivisions = ['管理課'];
        $divisions = array_diff($divisions, $excludeDivisions);
        foreach ($divisions as $id => $name) {
           $divisionsList[$id] = $name;
        }

        $data = [
            'user' => $user,
            'divisionsList' => $divisionsList,
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
        //アクセス権限の確認
        $user = $this->Users->get($id, [
            'contain' => ['Divisions'],
        ]);
        $this->checkPermission($user, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $userFormData = $this->request->getData();

            //自作関数からadminの値を取得
            $user->admin = $this->selectAdmin($userFormData);

            $user = $this->Users->patchEntity($user, $userFormData);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $divisions = $this->Divisions->find('list', ['limit' => 200, 'valueField' => 'division_name'])->order(['id' => 'ASC'])->toArray();
        

        $divisionsList = [];
        //フォームの選択リストに表示しないものを設定
        $excludeDivisions = ['管理課'];
        $divisions = array_diff($divisions, $excludeDivisions);
        foreach($divisions as $id => $name) {
            $divisionsList[$id] = $name;
        }

        $data = [
            'user' => $user,
            'divisionsList' => $divisionsList,
        ]; 

        $this->set($data);
    }

    //パスワード変更用のアクション
    public function changePassword($id)
    {
        $userData = [];

        $user = $this->Users->get($id, [
            'contain' => ['Divisions'],
        ]);

        //アクセス権限の確認
        $this->checkPermission($user, 'changePassword');

        $userData = $user->toArray();
        
        if ($this->request->is(['post', 'patch', 'put'])) {
            $password = $this->request->getData('newPassword');
            $confirmPassword = $this->request->getData('confirmPassword');
            //パスワードが一致していた場合の処理
            if ($password === $confirmPassword) {
                $userData['password'] = $password;
                $this->Users->patchEntity($user, $userData);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('パスワードを変更致しました。'));
                    return $this->redirect(['action' => 'view', $user->id]);
                } else {
                    $this->Flash->error(__('パスワードを変更できませんでした。もう一度やり直してください。'));
                }
            } else {
                $this->Flash->error(__('パスワードが一致しませんでした。もう一度やり直してください。'));
            }
        }

        $data = [
            'user' => $user,
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

        //アクセス権限の確認
        $user = $this->Users->get($id);
        $this->checkPermission($user, 'delete');

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function selectAdmin($formData) {

        $user = $this->Users->newEmptyEntity();

        //所属部署によって、adminを自動設定---division_idの1は管理者に設定
        if ($formData['division_id'] === '2') {  //division_idの2は経理に設定
            $user->admin = '経理';
        } elseif ($formData['division_id'] === '3') {  //division_idの3はシステムに設定
            $user->admin = 'システム';
        } else {
            $user->admin = '一般';
        }

        return $user->admin;
    }
}
