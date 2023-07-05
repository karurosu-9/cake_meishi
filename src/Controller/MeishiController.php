<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Meishi Controller
 *
 * @property \App\Model\Table\MeishiTable $Meishi
 * @method \App\Model\Entity\Meishi[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MeishiController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //権限が無くてもアクセスできるアクション
        if (in_array($this->request->getParam('action'), ['add', 'edit', 'delete'])) {
            $this->Authorization->skipAuthorization();
        }
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->Corps = $this->getTableLocator()->get('Corps');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //自作関数でのアクセス権限の確認
        $meishi = $this->Meishi->newEmptyEntity();
        $this->checkPermission($meishi, 'add');

        if ($this->request->is('post')) {

            $meishi = $this->Meishi->patchEntity($meishi, $this->request->getData());
            if ($this->Meishi->save($meishi)) {
                $this->Flash->success(__('The meishi has been saved.'));

                return $this->redirect(['controller' => 'Corps', 'action' => 'view', $meishi->corp_id]);
            }
            $this->Flash->error(__('The meishi could not be saved. Please, try again.'));
        }
        $corps = $this->Corps->find('list', ['limit' => 200, 'valueField' => 'corp_name'])->toArray();

        $data = [
            'meishi' => $meishi,
            'corps' => $corps
        ];

        $this->set($data);
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
            'contain' => ['Corps'],
        ]);

        //アクセス権限の確認
        $this->checkPermission($meishi, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $meishi = $this->Meishi->patchEntity($meishi, $this->request->getData());
            if ($this->Meishi->save($meishi)) {
                $this->Flash->success(__('The meishi has been saved.'));

                return $this->redirect(['controller' => 'Corps', 'action' => 'view', $meishi->corps->id]);
            }
            $this->Flash->error(__('The meishi could not be saved. Please, try again.'));
        }

        $data = [
            'meishi' => $meishi,
        ];
        
        $this->set($data);
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

        //アクセス権限の確認
        $meishi = $this->Meishi->get($id);
        $this->checkPermission($meishi, 'delete');

        if ($this->Meishi->delete($meishi)) {
            $this->Flash->success(__('The meishi has been deleted.'));
        } else {
            $this->Flash->error(__('The meishi could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
