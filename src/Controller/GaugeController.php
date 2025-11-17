<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Gauge Controller
 *
 * @property \App\Model\Table\GaugeTable $Gauge
 */
class GaugeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Gauge->find();
        $gauge = $this->paginate($query);

        $this->set(compact('gauge'));
    }

    /**
     * View method
     *
     * @param string|null $id Gauge id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gauge = $this->Gauge->get($id, contain: ['CalibrationRecord']);
        $this->set(compact('gauge'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gauge = $this->Gauge->newEmptyEntity();
        if ($this->request->is('post')) {
            $gauge = $this->Gauge->patchEntity($gauge, $this->request->getData());
            if ($this->Gauge->save($gauge)) {
                $this->Flash->success(__('The gauge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gauge could not be saved. Please, try again.'));
        }
        $this->set(compact('gauge'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gauge id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gauge = $this->Gauge->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gauge = $this->Gauge->patchEntity($gauge, $this->request->getData());
            if ($this->Gauge->save($gauge)) {
                $this->Flash->success(__('The gauge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The gauge could not be saved. Please, try again.'));
        }
        $this->set(compact('gauge'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gauge id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gauge = $this->Gauge->get($id);
        if ($this->Gauge->delete($gauge)) {
            $this->Flash->success(__('The gauge has been deleted.'));
        } else {
            $this->Flash->error(__('The gauge could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
