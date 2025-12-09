<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductFamilyChecklist Controller
 *
 * @property \App\Model\Table\ProductFamilyChecklistTable $ProductFamilyChecklist
 */
class ProductFamilyChecklistController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ProductFamilyChecklist->find()
            ->contain(['ProductFamilies', 'ChecklistTemplates']);
        $productFamilyChecklist = $this->paginate($query);

        $this->set(compact('productFamilyChecklist'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Family Checklist id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productFamilyChecklist = $this->ProductFamilyChecklist->get($id, contain: ['ProductFamilies', 'ChecklistTemplates']);
        $this->set(compact('productFamilyChecklist'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productFamilyChecklist = $this->ProductFamilyChecklist->newEmptyEntity();
        if ($this->request->is('post')) {
            $productFamilyChecklist = $this->ProductFamilyChecklist->patchEntity($productFamilyChecklist, $this->request->getData());
            if ($this->ProductFamilyChecklist->save($productFamilyChecklist)) {
                $this->Flash->success(__('The product family checklist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product family checklist could not be saved. Please, try again.'));
        }
        $productFamilies = $this->ProductFamilyChecklist->ProductFamilies->find('list', limit: 200)->all();
        $checklistTemplates = $this->ProductFamilyChecklist->ChecklistTemplates->find('list', limit: 200)->all();
        $this->set(compact('productFamilyChecklist', 'productFamilies', 'checklistTemplates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Family Checklist id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productFamilyChecklist = $this->ProductFamilyChecklist->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productFamilyChecklist = $this->ProductFamilyChecklist->patchEntity($productFamilyChecklist, $this->request->getData());
            if ($this->ProductFamilyChecklist->save($productFamilyChecklist)) {
                $this->Flash->success(__('The product family checklist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product family checklist could not be saved. Please, try again.'));
        }
        $productFamilies = $this->ProductFamilyChecklist->ProductFamilies->find('list', limit: 200)->all();
        $checklistTemplates = $this->ProductFamilyChecklist->ChecklistTemplates->find('list', limit: 200)->all();
        $this->set(compact('productFamilyChecklist', 'productFamilies', 'checklistTemplates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Family Checklist id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productFamilyChecklist = $this->ProductFamilyChecklist->get($id);
        if ($this->ProductFamilyChecklist->delete($productFamilyChecklist)) {
            $this->Flash->success(__('The product family checklist has been deleted.'));
        } else {
            $this->Flash->error(__('The product family checklist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
