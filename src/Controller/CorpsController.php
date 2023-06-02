<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Corps Controller
 *
 * @property \App\Model\Table\CorpsTable $Corps
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorpsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'Corps.corp_name' => 'ASC',
            ],
            'contain' => ['MeishiData'],
        ];

        $this->MeishiData = $this->getTableLocator()->get('MeishiData');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $loginUser = $this->Authentication->getResult()->getData();

        $keyword = $this->request->getData('keyword');

        $corps = $this->Corps->find('all');

        if (!empty($keyword)) {
            $corps->where(['Corps.corp_name LIKE' => '%' . $keyword . '%']);
        }

        $corpsCounter = $corps->count();

        $this->paginate = [
            'limit' => 20,
            'order' => [
                'Corps.corp_name' => 'ASC',
            ],
            'contain' => ['MeishiData'],
        ];

        $corps = $this->paginate($corps);

        $data = [
            'corps' => $corps,
            'corpsCounter' => $corpsCounter,
            'loginUser' => $loginUser,
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
    public function view($id = null)
    {

        $keyword = $this->request->getData('keyword');

        $meishiData = $this->MeishiData->find('all')->where(['MeishiData.corp_id' => $id])->contain(['Corps']);

        if (!empty($keyword)) {
            $meishiData->where(['MeishiData.employee_name LIKE' => '%' . $keyword . '%']);
        }

        $meishiDataCouner = $meishiData->count();

        $corp = $this->Corps->get($id, [
            'contain' => ['MeishiData'],
        ]);


        $this->paginate = [
            'limit' => 30,
            'contain' => ['Corps'],
            'order' => ['MeishiData.id' => 'ASC'],
        ];

        $meishiData = $this->paginate($meishiData);

        $data = [
            'corp' => $corp,
            'meishiData' => $meishiData,
            'meishiDataCounter' => $meishiDataCouner,
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
        $corp = $this->Corps->newEmptyEntity();
        if ($this->request->is('post')) {
            $corp = $this->Corps->patchEntity($corp, $this->request->getData());
            if ($this->Corps->save($corp)) {
                $this->Flash->success(__('The corp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corp could not be saved. Please, try again.'));
        }
        $this->set(compact('corp'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $corp = $this->Corps->patchEntity($corp, $this->request->getData());
            if ($this->Corps->save($corp)) {
                $this->Flash->success(__('The corp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corp could not be saved. Please, try again.'));
        }
        $this->set(compact('corp'));
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
        if ($this->Corps->delete($corp)) {
            $this->Flash->success(__('The corp has been deleted.'));
        } else {
            $this->Flash->error(__('The corp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
