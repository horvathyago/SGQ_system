<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MrbAction Controller
 *
 * @property \App\Model\Table\MrbActionTable $MrbAction
 */
class MrbActionController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->MrbAction->find()
            ->contain(['NonConformities', 'Responsavels']);
        $mrbAction = $this->paginate($query);

        $this->set(compact('mrbAction'));
    }

    /**
     * View method
     *
     * @param string|null $id Mrb Action id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mrbAction = $this->MrbAction->get($id, contain: ['NonConformities', 'Responsavels']);
        $this->set(compact('mrbAction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mrbAction = $this->MrbAction->newEmptyEntity();
        if ($this->request->is('post')) {
            $mrbAction = $this->MrbAction->patchEntity($mrbAction, $this->request->getData());
            if ($this->MrbAction->save($mrbAction)) {
                $this->Flash->success(__('The mrb action has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mrb action could not be saved. Please, try again.'));
        }
        $nonConformities = $this->MrbAction->NonConformities->find('list', limit: 200)->all();
        $responsavels = $this->MrbAction->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('mrbAction', 'nonConformities', 'responsavels'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mrb Action id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mrbAction = $this->MrbAction->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mrbAction = $this->MrbAction->patchEntity($mrbAction, $this->request->getData());
            if ($this->MrbAction->save($mrbAction)) {
                $this->Flash->success(__('The mrb action has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mrb action could not be saved. Please, try again.'));
        }
        $nonConformities = $this->MrbAction->NonConformities->find('list', limit: 200)->all();
        $responsavels = $this->MrbAction->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('mrbAction', 'nonConformities', 'responsavels'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mrb Action id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mrbAction = $this->MrbAction->get($id);
        if ($this->MrbAction->delete($mrbAction)) {
            $this->Flash->success(__('The mrb action has been deleted.'));
        } else {
            $this->Flash->error(__('The mrb action could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
