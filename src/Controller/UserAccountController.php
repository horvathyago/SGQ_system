<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * UserAccount Controller
 *
 * @property \App\Model\Table\UserAccountTable $UserAccount
 */
class UserAccountController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->UserAccount->find();
        $userAccount = $this->paginate($query);

        $this->set(compact('userAccount'));
    }

    /**
     * View method
     *
     * @param string|null $id User Account id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userAccount = $this->UserAccount->get($id, contain: []);
        $this->set(compact('userAccount'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userAccount = $this->UserAccount->newEmptyEntity();
        if ($this->request->is('post')) {
            $userAccount = $this->UserAccount->patchEntity($userAccount, $this->request->getData());
            if ($this->UserAccount->save($userAccount)) {
                $this->Flash->success(__('The user account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user account could not be saved. Please, try again.'));
        }
        $this->set(compact('userAccount'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userAccount = $this->UserAccount->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userAccount = $this->UserAccount->patchEntity($userAccount, $this->request->getData());
            if ($this->UserAccount->save($userAccount)) {
                $this->Flash->success(__('The user account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user account could not be saved. Please, try again.'));
        }
        $this->set(compact('userAccount'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Account id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userAccount = $this->UserAccount->get($id);
        if ($this->UserAccount->delete($userAccount)) {
            $this->Flash->success(__('The user account has been deleted.'));
        } else {
            $this->Flash->error(__('The user account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
