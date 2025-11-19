<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CalibrationRecord Controller
 *
 * @property \App\Model\Table\CalibrationRecordTable $CalibrationRecord
 */
class CalibrationRecordController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->CalibrationRecord->find()
            ->contain(['Gauges', 'LaudoDocuments']);
        $calibrationRecord = $this->paginate($query);

        $this->set(compact('calibrationRecord'));
    }

    /**
     * View method
     *
     * @param string|null $id Calibration Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $calibrationRecord = $this->CalibrationRecord->get($id, contain: ['Gauges', 'LaudoDocuments', 'InspectionItem']);
        $this->set(compact('calibrationRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $calibrationRecord = $this->CalibrationRecord->newEmptyEntity();
        if ($this->request->is('post')) {
            $calibrationRecord = $this->CalibrationRecord->patchEntity($calibrationRecord, $this->request->getData());
            if ($this->CalibrationRecord->save($calibrationRecord)) {
                $this->Flash->success(__('The calibration record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The calibration record could not be saved. Please, try again.'));
        }
        $gauges = $this->CalibrationRecord->Gauges->find('list', limit: 200)->all();
        $laudoDocuments = $this->CalibrationRecord->LaudoDocuments->find('list', limit: 200)->all();
        $this->set(compact('calibrationRecord', 'gauges', 'laudoDocuments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Calibration Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $calibrationRecord = $this->CalibrationRecord->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $calibrationRecord = $this->CalibrationRecord->patchEntity($calibrationRecord, $this->request->getData());
            if ($this->CalibrationRecord->save($calibrationRecord)) {
                $this->Flash->success(__('The calibration record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The calibration record could not be saved. Please, try again.'));
        }
        $gauges = $this->CalibrationRecord->Gauges->find('list', limit: 200)->all();
        $laudoDocuments = $this->CalibrationRecord->LaudoDocuments->find('list', limit: 200)->all();
        $this->set(compact('calibrationRecord', 'gauges', 'laudoDocuments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Calibration Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $calibrationRecord = $this->CalibrationRecord->get($id);
        if ($this->CalibrationRecord->delete($calibrationRecord)) {
            $this->Flash->success(__('The calibration record has been deleted.'));
        } else {
            $this->Flash->error(__('The calibration record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
