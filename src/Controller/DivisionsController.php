<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Divisions Controller
 *
 * @property \App\Model\Table\DivisionsTable $Divisions
 * @method \App\Model\Entity\Division[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DivisionsController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        $this->paginate = [
            'limit' => 10,
            'contain' => ['Users'],
        ];

        $this->Users = $this->getTableLocator()->get('Users');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $divisions = $this->Divisions->find('all');

        $keyword = $this->request->getData('keyword');

        if (!empty($keyword)) {
            $divisions= $this->Divisions->find()->where(['Divisions.divisionName LIKE'=> '%' . $keyword . '%' ]);
        }

        $divisions = $this->paginate($divisions);

        $data = [
            'divisions' => $divisions,
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

        $users = $this->Users->find()->contain(['Divisions'])->toArray();
        var_dump($users); exit;

        $division = $this->Divisions->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('division'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $division = $this->Divisions->newEmptyEntity();
        if ($this->request->is('post')) {
            $division = $this->Divisions->patchEntity($division, $this->request->getData());
            if ($this->Divisions->save($division)) {
                $this->Flash->success(__('The division has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The division could not be saved. Please, try again.'));
        }
        $this->set(compact('division'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $division = $this->Divisions->patchEntity($division, $this->request->getData());
            if ($this->Divisions->save($division)) {
                $this->Flash->success(__('The division has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The division could not be saved. Please, try again.'));
        }
        $this->set(compact('division'));
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
        if ($this->Divisions->delete($division)) {
            $this->Flash->success(__('The division has been deleted.'));
        } else {
            $this->Flash->error(__('The division could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
