<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * NonConformity Controller
 *
 * @property \App\Model\Table\NonConformityTable $NonConformity
 */
class NonConformityController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->NonConformity->find()
            ->contain(['InspectionItems', 'Responsavels']);
        $nonConformity = $this->paginate($query);

        $this->set(compact('nonConformity'));
    }

    /**
     * View method
     *
     * @param string|null $id Non Conformity id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nonConformity = $this->NonConformity->get($id, contain: ['InspectionItems', 'Responsavels', 'MrbAction']);
        $this->set(compact('nonConformity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $nonConformity = $this->NonConformity->newEmptyEntity();
        if ($this->request->is('post')) {
            $nonConformity = $this->NonConformity->patchEntity($nonConformity, $this->request->getData());
            if ($this->NonConformity->save($nonConformity)) {
                $this->Flash->success(__('The non conformity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The non conformity could not be saved. Please, try again.'));
        }
        $inspectionItems = $this->NonConformity->InspectionItems->find('list', limit: 200)->all();
        $responsavels = $this->NonConformity->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('nonConformity', 'inspectionItems', 'responsavels'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Non Conformity id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $nonConformity = $this->NonConformity->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $nonConformity = $this->NonConformity->patchEntity($nonConformity, $this->request->getData());
            if ($this->NonConformity->save($nonConformity)) {
                $this->Flash->success(__('The non conformity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The non conformity could not be saved. Please, try again.'));
        }
        $inspectionItems = $this->NonConformity->InspectionItems->find('list', limit: 200)->all();
        $responsavels = $this->NonConformity->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('nonConformity', 'inspectionItems', 'responsavels'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Non Conformity id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nonConformity = $this->NonConformity->get($id);
        if ($this->NonConformity->delete($nonConformity)) {
            $this->Flash->success(__('The non conformity has been deleted.'));
        } else {
            $this->Flash->error(__('The non conformity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
