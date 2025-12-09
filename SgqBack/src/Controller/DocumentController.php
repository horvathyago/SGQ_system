<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Document Controller
 *
 * @property \App\Model\Table\DocumentTable $Document
 */
class DocumentController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Document->find()
            ->contain(['Uploaders']);
        $document = $this->paginate($query);

        $this->set(compact('document'));
    }

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $document = $this->Document->get($id, contain: ['Uploaders', 'DocumentLink']);
        $this->set(compact('document'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $document = $this->Document->newEmptyEntity();
        if ($this->request->is('post')) {
            $document = $this->Document->patchEntity($document, $this->request->getData());
            if ($this->Document->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $uploaders = $this->Document->Uploaders->find('list', limit: 200)->all();
        $this->set(compact('document', 'uploaders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Document->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Document->patchEntity($document, $this->request->getData());
            if ($this->Document->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $uploaders = $this->Document->Uploaders->find('list', limit: 200)->all();
        $this->set(compact('document', 'uploaders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Document->get($id);
        if ($this->Document->delete($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
