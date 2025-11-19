<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DocumentLink Controller
 *
 * @property \App\Model\Table\DocumentLinkTable $DocumentLink
 */
class DocumentLinkController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DocumentLink->find()
            ->contain(['Documents']);
        $documentLink = $this->paginate($query);

        $this->set(compact('documentLink'));
    }

    /**
     * View method
     *
     * @param string|null $id Document Link id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentLink = $this->DocumentLink->get($id, contain: ['Documents']);
        $this->set(compact('documentLink'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentLink = $this->DocumentLink->newEmptyEntity();
        if ($this->request->is('post')) {
            $documentLink = $this->DocumentLink->patchEntity($documentLink, $this->request->getData());
            if ($this->DocumentLink->save($documentLink)) {
                $this->Flash->success(__('The document link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document link could not be saved. Please, try again.'));
        }
        $documents = $this->DocumentLink->Documents->find('list', limit: 200)->all();
        $this->set(compact('documentLink', 'documents'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Link id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentLink = $this->DocumentLink->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentLink = $this->DocumentLink->patchEntity($documentLink, $this->request->getData());
            if ($this->DocumentLink->save($documentLink)) {
                $this->Flash->success(__('The document link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document link could not be saved. Please, try again.'));
        }
        $documents = $this->DocumentLink->Documents->find('list', limit: 200)->all();
        $this->set(compact('documentLink', 'documents'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Link id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentLink = $this->DocumentLink->get($id);
        if ($this->DocumentLink->delete($documentLink)) {
            $this->Flash->success(__('The document link has been deleted.'));
        } else {
            $this->Flash->error(__('The document link could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
