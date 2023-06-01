<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MeishiData Controller
 *
 * @property \App\Model\Table\MeishiDataTable $MeishiData
 * @method \App\Model\Entity\MeishiData[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MeishiDataController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Corps'],
            'limit' => 30,
            'order' => ['MeishiData.id' => 'ASC'],
        ];
        $meishiData = $this->paginate($this->MeishiData);

        $this->set(compact('meishiData'));
    }

    /**
     * View method
     *
     * @param string|null $id Meishi Data id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $meishiData = $this->MeishiData->get($id, [
            'contain' => ['Corps'],
        ]);

        $this->set(compact('meishiData'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $meishiData = $this->MeishiData->newEmptyEntity();
        if ($this->request->is('post')) {
            $meishiData = $this->MeishiData->patchEntity($meishiData, $this->request->getData());
            if ($this->MeishiData->save($meishiData)) {
                $this->Flash->success(__('The meishi data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meishi data could not be saved. Please, try again.'));
        }
        $corps = $this->MeishiData->Corps->find('list', ['limit' => 200])->all();
        $this->set(compact('meishiData', 'corps'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Meishi Data id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $meishiData = $this->MeishiData->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $meishiData = $this->MeishiData->patchEntity($meishiData, $this->request->getData());
            if ($this->MeishiData->save($meishiData)) {
                $this->Flash->success(__('The meishi data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meishi data could not be saved. Please, try again.'));
        }
        $corps = $this->MeishiData->Corps->find('list', ['limit' => 200])->all();
        $this->set(compact('meishiData', 'corps'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Meishi Data id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $meishiData = $this->MeishiData->get($id);
        if ($this->MeishiData->delete($meishiData)) {
            $this->Flash->success(__('The meishi data has been deleted.'));
        } else {
            $this->Flash->error(__('The meishi data could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
