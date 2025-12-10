<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\View\JsonView;

/**
 * InspectionItem Controller (API)
 *
 * @property \App\Model\Table\InspectionItemTable $InspectionItem
 */
class InspectionItemController extends AppController
{
    // 🎯 Correção: Configura a view padrão para JSON
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        // 🚨 RequestHandlerComponent REMOVIDO
        $this->viewBuilder()->setClassName('Json');

        if ($this->components()->has('Flash')) {
            $this->loadComponent('Flash')->setConfig('allowedActions', []);
        }
    }

    /**
     * Rota: GET /inspection-item
     */
    public function index(): ?Response
    {
        $query = $this->InspectionItem->find()
            ->contain(['Inspections', 'ItemMasters', 'TemplateItems', 'CalibrationRecords']);
        $inspectionItem = $this->paginate($query);

        $this->set(compact('inspectionItem'));
        $this->viewBuilder()->setOption('serialize', 'inspectionItem');
        return null;
    }

    /**
     * Rota: GET /inspection-item/{id}
     */
    public function view($id = null): ?Response
    {
        try {
            $inspectionItem = $this->InspectionItem->get($id, [
                'contain' => ['Inspections', 'ItemMasters', 'TemplateItems', 'CalibrationRecords', 'NonConformity']
            ]);
            $this->set(compact('inspectionItem'));
            $this->viewBuilder()->setOption('serialize', 'inspectionItem');
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Inspection Item not found']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }

    /**
     * Rota: POST /inspection-item
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $inspectionItem = $this->InspectionItem->newEmptyEntity();
        $inspectionItem = $this->InspectionItem->patchEntity($inspectionItem, $this->request->getData());
        
        if ($this->InspectionItem->save($inspectionItem)) {
            
            $this->set([
                'inspectionItem' => $inspectionItem,
                'message' => 'Inspection Item created successfully',
            ]);
            $this->viewBuilder()->setOption('serialize', ['inspectionItem', 'message']);
            $this->response = $this->response->withStatus(201); // 201 Created
        } else {
            $this->set([
                'message' => 'Validation error',
                'errors' => $inspectionItem->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: PUT/PATCH /inspection-item/{id}
     */
    public function edit($id = null): ?Response
    {
        $this->request->allowMethod(['patch', 'put']);

        try {
            $inspectionItem = $this->InspectionItem->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Inspection Item not found for editing']);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return null;
        }

        $inspectionItem = $this->InspectionItem->patchEntity($inspectionItem, $this->request->getData());
        
        if ($this->InspectionItem->save($inspectionItem)) {
            
            $this->set([
                'inspectionItem' => $inspectionItem,
                'message' => 'Inspection Item updated successfully',
            ]);
            $this->viewBuilder()->setOption('serialize', ['inspectionItem', 'message']);
            $this->response = $this->response->withStatus(200);
        } else {
            $this->set([
                'message' => 'Validation error',
                'errors' => $inspectionItem->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: DELETE /inspection-item/{id}
     */
    public function delete($id = null): ?Response
    {
        $this->request->allowMethod(['delete']);

        try {
            $inspectionItem = $this->InspectionItem->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(204);
            return null;
        }

        if ($this->InspectionItem->delete($inspectionItem)) {
            $this->response = $this->response->withStatus(204);
        } else {
            $this->response = $this->response->withStatus(500);
            $this->set(['message' => 'Inspection Item could not be deleted']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }
}