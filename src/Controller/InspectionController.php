<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\ForbiddenException;


/**
 * Inspection Controller
 *
 * @property \App\Model\Table\InspectionTable $Inspection
 */
class InspectionController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Inspection->find()
            ->contain(['ProductionOrders', 'ChecklistTemplates', 'ChecklistTemplateVersions', 'Inspectors']);
        $inspection = $this->paginate($query);

        $this->set(compact('inspection'));
    }

    /**
     * View method
     *
     * @param string|null $id Inspection id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inspection = $this->Inspection->get($id, contain: ['ProductionOrders', 'ChecklistTemplates', 'ChecklistTemplateVersions', 'Inspectors', 'InspectionItem']);
        $this->set(compact('inspection'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inspection = $this->Inspection->newEmptyEntity();
        $this->Authorization->authorize($inspection);
        if ($this->request->is('post')) {
            $inspection = $this->Inspection->patchEntity($inspection, $this->request->getData());
            if ($this->Inspection->save($inspection)) {
                $this->Flash->success(__('The inspection has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inspection could not be saved. Please, try again.'));
        }
        $productionOrders = $this->Inspection->ProductionOrders->find('list', limit: 200)->all();
        $checklistTemplates = $this->Inspection->ChecklistTemplates->find('list', limit: 200)->all();
        $checklistTemplateVersions = $this->Inspection->ChecklistTemplateVersions->find('list', limit: 200)->all();
        $inspectors = $this->Inspection->Inspectors->find('list', limit: 200)->all();
        $this->set(compact('inspection', 'productionOrders', 'checklistTemplates', 'checklistTemplateVersions', 'inspectors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inspection id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // 1) Carrega a entidade Inspection
        $inspection = $this->Inspection->get($id, contain: []);

        // 2) Obtém a Identity de forma robusta
        $identity = $this->request->getAttribute('identity');
        if ($identity === null && isset($this->Authentication)) {
            $identity = $this->Authentication->getIdentity();
        }

        if ($identity === null) {
            // usuário não autenticado
            throw new ForbiddenException('Usuário não autenticado.');
        }

        // 3) (Opcional) obtenha dados para debug em dev - remova/comment após checagem
        // debug($identity->getOriginalData()); debug($inspection); // apenas dev

        // 4) Delega toda a decisão para a Policy: Authorization cuidará do resto.
        //    Se o usuário NÃO tiver permissão, Authorization lança ForbiddenException.
        $this->Authorization->authorize($inspection, 'edit');

        // 5) Fluxo de update normal (só chega aqui se autorizado)
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inspection = $this->Inspection->patchEntity($inspection, $this->request->getData());

            if ($this->Inspection->save($inspection)) {
                $this->Flash->success(__('The inspection has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inspection could not be saved. Please, try again.'));
        }

        // 6) Dados para o formulário
        $productionOrders = $this->Inspection->ProductionOrders->find('list', limit: 200)->all();
        $checklistTemplates = $this->Inspection->ChecklistTemplates->find('list', limit: 200)->all();
        $checklistTemplateVersions = $this->Inspection->ChecklistTemplateVersions->find('list', limit: 200)->all();
        $inspectors = $this->Inspection->Inspectors->find('list', limit: 200)->all();

        $this->set(compact(
            'inspection',
            'productionOrders',
            'checklistTemplates',
            'checklistTemplateVersions',
            'inspectors'
        ));
    }


    /**
     * Delete method
     *
     * @param string|null $id Inspection id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inspection = $this->Inspection->get($id);
        if ($this->Inspection->delete($inspection)) {
            $this->Flash->success(__('The inspection has been deleted.'));
        } else {
            $this->Flash->error(__('The inspection could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
