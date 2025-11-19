<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InspectionItem Controller
 *
 * @property \App\Model\Table\InspectionItemTable $InspectionItem
 */
class InspectionItemController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->InspectionItem->find()
            ->contain(['Inspections', 'ItemMasters', 'TemplateItems', 'CalibrationRecords']);
        $inspectionItem = $this->paginate($query);

        $this->set(compact('inspectionItem'));
    }

    /**
     * View method
     *
     * @param string|null $id Inspection Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inspectionItem = $this->InspectionItem->get($id, contain: ['Inspections', 'ItemMasters', 'TemplateItems', 'CalibrationRecords', 'NonConformity']);
        $this->set(compact('inspectionItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inspectionItem = $this->InspectionItem->newEmptyEntity();
        if ($this->request->is('post')) {
            $inspectionItem = $this->InspectionItem->patchEntity($inspectionItem, $this->request->getData());
            if ($this->InspectionItem->save($inspectionItem)) {
                $this->Flash->success(__('The inspection item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inspection item could not be saved. Please, try again.'));
        }
        $inspections = $this->InspectionItem->Inspections->find('list', limit: 200)->all();
        $itemMasters = $this->InspectionItem->ItemMasters->find('list', limit: 200)->all();
        $templateItems = $this->InspectionItem->TemplateItems->find('list', limit: 200)->all();
        $calibrationRecords = $this->InspectionItem->CalibrationRecords->find('list', limit: 200)->all();
        $this->set(compact('inspectionItem', 'inspections', 'itemMasters', 'templateItems', 'calibrationRecords'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inspection Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inspectionItem = $this->InspectionItem->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inspectionItem = $this->InspectionItem->patchEntity($inspectionItem, $this->request->getData());
            if ($this->InspectionItem->save($inspectionItem)) {
                $this->Flash->success(__('The inspection item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inspection item could not be saved. Please, try again.'));
        }
        $inspections = $this->InspectionItem->Inspections->find('list', limit: 200)->all();
        $itemMasters = $this->InspectionItem->ItemMasters->find('list', limit: 200)->all();
        $templateItems = $this->InspectionItem->TemplateItems->find('list', limit: 200)->all();
        $calibrationRecords = $this->InspectionItem->CalibrationRecords->find('list', limit: 200)->all();
        $this->set(compact('inspectionItem', 'inspections', 'itemMasters', 'templateItems', 'calibrationRecords'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inspection Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inspectionItem = $this->InspectionItem->get($id);
        if ($this->InspectionItem->delete($inspectionItem)) {
            $this->Flash->success(__('The inspection item has been deleted.'));
        } else {
            $this->Flash->error(__('The inspection item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
