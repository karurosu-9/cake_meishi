<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Meishi Controller
 *
 * @property \App\Model\Table\MeishiTable $Meishi
 * @method \App\Model\Entity\Meishi[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MeishiController extends AppController
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
        ];
        $meishi = $this->paginate($this->Meishi);

        $this->set(compact('meishi'));
    }

    /**
     * View method
     *
     * @param string|null $id Meishi id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $meishi = $this->Meishi->get($id, [
            'contain' => ['Corps'],
        ]);

        $this->set(compact('meishi'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $meishi = $this->Meishi->newEmptyEntity();
        if ($this->request->is('post')) {
            $meishi = $this->Meishi->patchEntity($meishi, $this->request->getData());
            if ($this->Meishi->save($meishi)) {
                $this->Flash->success(__('The meishi has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meishi could not be saved. Please, try again.'));
        }
        $corps = $this->Meishi->Corps->find('list', ['limit' => 200])->all();
        $this->set(compact('meishi', 'corps'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Meishi id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $meishi = $this->Meishi->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $meishi = $this->Meishi->patchEntity($meishi, $this->request->getData());
            if ($this->Meishi->save($meishi)) {
                $this->Flash->success(__('The meishi has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The meishi could not be saved. Please, try again.'));
        }
        $corps = $this->Meishi->Corps->find('list', ['limit' => 200])->all();
        $this->set(compact('meishi', 'corps'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Meishi id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $meishi = $this->Meishi->get($id);
        if ($this->Meishi->delete($meishi)) {
            $this->Flash->success(__('The meishi has been deleted.'));
        } else {
            $this->Flash->error(__('The meishi could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
