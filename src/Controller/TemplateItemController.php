<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TemplateItem Controller
 *
 * @property \App\Model\Table\TemplateItemTable $TemplateItem
 */
class TemplateItemController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TemplateItem->find()
            ->contain(['ChecklistTemplateVersions', 'ItemMasters']);
        $templateItem = $this->paginate($query);

        $this->set(compact('templateItem'));
    }

    /**
     * View method
     *
     * @param string|null $id Template Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $templateItem = $this->TemplateItem->get($id, contain: ['ChecklistTemplateVersions', 'ItemMasters', 'InspectionItem']);
        $this->set(compact('templateItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $templateItem = $this->TemplateItem->newEmptyEntity();
        if ($this->request->is('post')) {
            $templateItem = $this->TemplateItem->patchEntity($templateItem, $this->request->getData());
            if ($this->TemplateItem->save($templateItem)) {
                $this->Flash->success(__('The template item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The template item could not be saved. Please, try again.'));
        }
        $checklistTemplateVersions = $this->TemplateItem->ChecklistTemplateVersions->find('list', limit: 200)->all();
        $itemMasters = $this->TemplateItem->ItemMasters->find('list', limit: 200)->all();
        $this->set(compact('templateItem', 'checklistTemplateVersions', 'itemMasters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Template Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $templateItem = $this->TemplateItem->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $templateItem = $this->TemplateItem->patchEntity($templateItem, $this->request->getData());
            if ($this->TemplateItem->save($templateItem)) {
                $this->Flash->success(__('The template item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The template item could not be saved. Please, try again.'));
        }
        $checklistTemplateVersions = $this->TemplateItem->ChecklistTemplateVersions->find('list', limit: 200)->all();
        $itemMasters = $this->TemplateItem->ItemMasters->find('list', limit: 200)->all();
        $this->set(compact('templateItem', 'checklistTemplateVersions', 'itemMasters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Template Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $templateItem = $this->TemplateItem->get($id);
        if ($this->TemplateItem->delete($templateItem)) {
            $this->Flash->success(__('The template item has been deleted.'));
        } else {
            $this->Flash->error(__('The template item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
