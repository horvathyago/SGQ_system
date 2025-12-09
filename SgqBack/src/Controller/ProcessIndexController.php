<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProcessIndex Controller
 *
 * @property \App\Model\Table\ProcessIndexTable $ProcessIndex
 */
class ProcessIndexController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ProcessIndex->find()
            ->contain(['ProductFamilies']);
        $processIndex = $this->paginate($query);

        $this->set(compact('processIndex'));
    }

    /**
     * View method
     *
     * @param string|null $id Process Index id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $processIndex = $this->ProcessIndex->get($id, contain: ['ProductFamilies']);
        $this->set(compact('processIndex'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $processIndex = $this->ProcessIndex->newEmptyEntity();
        if ($this->request->is('post')) {
            $processIndex = $this->ProcessIndex->patchEntity($processIndex, $this->request->getData());
            if ($this->ProcessIndex->save($processIndex)) {
                $this->Flash->success(__('The process index has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The process index could not be saved. Please, try again.'));
        }
        $productFamilies = $this->ProcessIndex->ProductFamilies->find('list', limit: 200)->all();
        $this->set(compact('processIndex', 'productFamilies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Process Index id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $processIndex = $this->ProcessIndex->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $processIndex = $this->ProcessIndex->patchEntity($processIndex, $this->request->getData());
            if ($this->ProcessIndex->save($processIndex)) {
                $this->Flash->success(__('The process index has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The process index could not be saved. Please, try again.'));
        }
        $productFamilies = $this->ProcessIndex->ProductFamilies->find('list', limit: 200)->all();
        $this->set(compact('processIndex', 'productFamilies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Process Index id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $processIndex = $this->ProcessIndex->get($id);
        if ($this->ProcessIndex->delete($processIndex)) {
            $this->Flash->success(__('The process index has been deleted.'));
        } else {
            $this->Flash->error(__('The process index could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
