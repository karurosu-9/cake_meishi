<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Home Controller
 *
 * @method \App\Model\Entity\Home[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        //権限が無くてもアクセスできるアクション
        if (in_array($this->request->getParam('action'), ['index'])) {
            $this->Authorization->skipAuthorization();
          }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $loginUser = $this->Authentication->getResult()->getData();

        $data = [
            'loginUser' => $loginUser,
        ];

        $this->set($data);
    }

}
