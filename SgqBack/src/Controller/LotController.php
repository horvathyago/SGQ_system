<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Lot Controller
 *
 * @property \App\Model\Table\LotTable $Lot
 */
class LotController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Lot->find()
            ->contain(['ProductFamilies', 'ProductionOrders']);
        $lot = $this->paginate($query);

        $this->set(compact('lot'));
    }

    /**
     * View method
     *
     * @param string|null $id Lot id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lot = $this->Lot->get($id, contain: ['ProductFamilies', 'ProductionOrders']);
        $this->set(compact('lot'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lot = $this->Lot->newEmptyEntity();
        if ($this->request->is('post')) {
            $lot = $this->Lot->patchEntity($lot, $this->request->getData());
            if ($this->Lot->save($lot)) {
                $this->Flash->success(__('The lot has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lot could not be saved. Please, try again.'));
        }
        $productFamilies = $this->Lot->ProductFamilies->find('list', limit: 200)->all();
        $productionOrders = $this->Lot->ProductionOrders->find('list', limit: 200)->all();
        $this->set(compact('lot', 'productFamilies', 'productionOrders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lot id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lot = $this->Lot->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lot = $this->Lot->patchEntity($lot, $this->request->getData());
            if ($this->Lot->save($lot)) {
                $this->Flash->success(__('The lot has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lot could not be saved. Please, try again.'));
        }
        $productFamilies = $this->Lot->ProductFamilies->find('list', limit: 200)->all();
        $productionOrders = $this->Lot->ProductionOrders->find('list', limit: 200)->all();
        $this->set(compact('lot', 'productFamilies', 'productionOrders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lot id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lot = $this->Lot->get($id);
        if ($this->Lot->delete($lot)) {
            $this->Flash->success(__('The lot has been deleted.'));
        } else {
            $this->Flash->error(__('The lot could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
