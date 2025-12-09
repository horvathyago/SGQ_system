<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AuditLog Controller
 *
 * @property \App\Model\Table\AuditLogTable $AuditLog
 */
class AuditLogController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AuditLog->find()
            ->contain(['Users']);
        $auditLog = $this->paginate($query);

        $this->set(compact('auditLog'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit Log id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditLog = $this->AuditLog->get($id, contain: ['Users']);
        $this->set(compact('auditLog'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditLog = $this->AuditLog->newEmptyEntity();
        if ($this->request->is('post')) {
            $auditLog = $this->AuditLog->patchEntity($auditLog, $this->request->getData());
            if ($this->AuditLog->save($auditLog)) {
                $this->Flash->success(__('The audit log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit log could not be saved. Please, try again.'));
        }
        $users = $this->AuditLog->Users->find('list', limit: 200)->all();
        $this->set(compact('auditLog', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit Log id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditLog = $this->AuditLog->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditLog = $this->AuditLog->patchEntity($auditLog, $this->request->getData());
            if ($this->AuditLog->save($auditLog)) {
                $this->Flash->success(__('The audit log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit log could not be saved. Please, try again.'));
        }
        $users = $this->AuditLog->Users->find('list', limit: 200)->all();
        $this->set(compact('auditLog', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditLog = $this->AuditLog->get($id);
        if ($this->AuditLog->delete($auditLog)) {
            $this->Flash->success(__('The audit log has been deleted.'));
        } else {
            $this->Flash->error(__('The audit log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
