<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductFamily Controller
 *
 * @property \App\Model\Table\ProductFamilyTable $ProductFamily
 */
class ProductFamilyController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ProductFamily->find();
        $productFamily = $this->paginate($query);

        $this->set(compact('productFamily'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Family id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productFamily = $this->ProductFamily->get($id, contain: ['Lot', 'ProcessIndex', 'ProductFamilyChecklist', 'ProductionOrder']);
        $this->set(compact('productFamily'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productFamily = $this->ProductFamily->newEmptyEntity();
        if ($this->request->is('post')) {
            $productFamily = $this->ProductFamily->patchEntity($productFamily, $this->request->getData());
            if ($this->ProductFamily->save($productFamily)) {
                $this->Flash->success(__('The product family has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product family could not be saved. Please, try again.'));
        }
        $this->set(compact('productFamily'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Family id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productFamily = $this->ProductFamily->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productFamily = $this->ProductFamily->patchEntity($productFamily, $this->request->getData());
            if ($this->ProductFamily->save($productFamily)) {
                $this->Flash->success(__('The product family has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product family could not be saved. Please, try again.'));
        }
        $this->set(compact('productFamily'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Family id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productFamily = $this->ProductFamily->get($id);
        if ($this->ProductFamily->delete($productFamily)) {
            $this->Flash->success(__('The product family has been deleted.'));
        } else {
            $this->Flash->error(__('The product family could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
