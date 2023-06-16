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
            'limit' => 30,
            'order' => [
                'Corps.corp_name' => 'ASC',
            ],
        ];

        $this->Meishi = $this->getTableLocator()->get('Meishi');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $loginUser = $this->Authentication->getResult()->getData();

        $corps = $this->Corps->find('all');

        $keyword = '';

        if ($this->request->is('put')) {
            $keyword = $this->request->getData('keyword');
            $corps->where(['Corps.corp_name LIKE' => '%' . $keyword .'%']);
        }

        $corpsCount = $corps->count();

        $corps = $this->paginate($corps);

        $data = [
            'corps' => $corps,
            'corpsCount' => $corpsCount,
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

        $meishiData = $this->Meishi->find('all')->where(['Meishi.corp_id' => $id])->contain(['Corps']);

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
            'meishiDataCount' => $meishiDataCount,
            'corp' => $corp,
        ];

        $this->set($data);

        $this->set(compact('corp'));
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
