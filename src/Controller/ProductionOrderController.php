<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductionOrder Controller
 *
 * @property \App\Model\Table\ProductionOrderTable $ProductionOrder
 */
class ProductionOrderController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ProductionOrder->find()
            ->contain(['ProductFamilies']);
        $productionOrder = $this->paginate($query);

        $this->set(compact('productionOrder'));
    }

    /**
     * View method
     *
     * @param string|null $id Production Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productionOrder = $this->ProductionOrder->get($id, contain: ['ProductFamilies', 'Inspection', 'Lot']);
        $this->set(compact('productionOrder'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productionOrder = $this->ProductionOrder->newEmptyEntity();
        if ($this->request->is('post')) {
            $productionOrder = $this->ProductionOrder->patchEntity($productionOrder, $this->request->getData());
            if ($this->ProductionOrder->save($productionOrder)) {
                $this->Flash->success(__('The production order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The production order could not be saved. Please, try again.'));
        }
        $productFamilies = $this->ProductionOrder->ProductFamilies->find('list', limit: 200)->all();
        $this->set(compact('productionOrder', 'productFamilies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Production Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productionOrder = $this->ProductionOrder->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productionOrder = $this->ProductionOrder->patchEntity($productionOrder, $this->request->getData());
            if ($this->ProductionOrder->save($productionOrder)) {
                $this->Flash->success(__('The production order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The production order could not be saved. Please, try again.'));
        }
        $productFamilies = $this->ProductionOrder->ProductFamilies->find('list', limit: 200)->all();
        $this->set(compact('productionOrder', 'productFamilies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Production Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productionOrder = $this->ProductionOrder->get($id);
        if ($this->ProductionOrder->delete($productionOrder)) {
            $this->Flash->success(__('The production order has been deleted.'));
        } else {
            $this->Flash->error(__('The production order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
