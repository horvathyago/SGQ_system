<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ChecklistTemplateVersion Controller
 *
 * @property \App\Model\Table\ChecklistTemplateVersionTable $ChecklistTemplateVersion
 */
class ChecklistTemplateVersionController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ChecklistTemplateVersion->find()
            ->contain(['ChecklistTemplates']);
        $checklistTemplateVersion = $this->paginate($query);

        $this->set(compact('checklistTemplateVersion'));
    }

    /**
     * View method
     *
     * @param string|null $id Checklist Template Version id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $checklistTemplateVersion = $this->ChecklistTemplateVersion->get($id, contain: ['ChecklistTemplates', 'Inspection', 'TemplateItem']);
        $this->set(compact('checklistTemplateVersion'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $checklistTemplateVersion = $this->ChecklistTemplateVersion->newEmptyEntity();
        if ($this->request->is('post')) {
            $checklistTemplateVersion = $this->ChecklistTemplateVersion->patchEntity($checklistTemplateVersion, $this->request->getData());
            if ($this->ChecklistTemplateVersion->save($checklistTemplateVersion)) {
                $this->Flash->success(__('The checklist template version has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The checklist template version could not be saved. Please, try again.'));
        }
        $checklistTemplates = $this->ChecklistTemplateVersion->ChecklistTemplates->find('list', limit: 200)->all();
        $this->set(compact('checklistTemplateVersion', 'checklistTemplates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Checklist Template Version id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $checklistTemplateVersion = $this->ChecklistTemplateVersion->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $checklistTemplateVersion = $this->ChecklistTemplateVersion->patchEntity($checklistTemplateVersion, $this->request->getData());
            if ($this->ChecklistTemplateVersion->save($checklistTemplateVersion)) {
                $this->Flash->success(__('The checklist template version has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The checklist template version could not be saved. Please, try again.'));
        }
        $checklistTemplates = $this->ChecklistTemplateVersion->ChecklistTemplates->find('list', limit: 200)->all();
        $this->set(compact('checklistTemplateVersion', 'checklistTemplates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Checklist Template Version id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $checklistTemplateVersion = $this->ChecklistTemplateVersion->get($id);
        if ($this->ChecklistTemplateVersion->delete($checklistTemplateVersion)) {
            $this->Flash->success(__('The checklist template version has been deleted.'));
        } else {
            $this->Flash->error(__('The checklist template version could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
