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
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setClassName('Json');

        if ($this->components()->has('Flash')) {
            $this->loadComponent('Flash')->setConfig('allowedActions', []);
        }
    }

    /**
     * Rota: GET /inspection-item/index.json
     * Suporta query params:
     *  - inspection_id (UUID) -> filtra itens pertencentes a uma Inspection
     *  - phase_id (string/identificador) -> filtra por TemplateItems.phase_id (faz matching)
     */
    public function index(): ?Response
    {
        $inspectionId = $this->request->getQuery('inspection_id');
        $phaseId = $this->request->getQuery('phase_id');

        $query = $this->InspectionItem->find()
            ->contain(['Inspections', 'ItemMasters', 'TemplateItems', 'CalibrationRecords']);

        if ($inspectionId) {
            $query->where(['InspectionItem.inspection_id' => $inspectionId]);
        }

        if ($phaseId) {
            // Faz matching com TemplateItems para filtrar por phase_id
            $query = $query->matching('TemplateItems', function ($q) use ($phaseId) {
                return $q->where(['TemplateItems.phase_id' => $phaseId]);
            });
        }

        $query->order(['InspectionItem.ordem' => 'ASC']);

        $inspectionItems = $this->paginate($query);

        $this->set(compact('inspectionItems'));
        $this->viewBuilder()->setOption('serialize', 'inspectionItems');
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
     *
     * Aceita payloads individuais (objeto) ou arrays para criação em lote.
     * Retorna 201 com lista de inspectionItems criados ou 422 com erros por índice.
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        // Se vier um array de arrays => batch
        if (is_array($data) && array_values($data) === $data) {
            // Batch flow
            $entities = $this->InspectionItem->newEntities($data);

            // Tenta salvar todos (retorna false se houver falhas)
            $saved = $this->InspectionItem->saveMany($entities);

            if ($saved !== false) {
                // Normaliza para array de arrays/objetos
                $savedArray = [];
                foreach ($saved as $s) {
                    $savedArray[] = $s;
                }

                $this->set([
                    'inspectionItems' => $savedArray,
                    'message' => 'Inspection Items created successfully'
                ]);
                $this->viewBuilder()->setOption('serialize', ['inspectionItems', 'message']);
                $this->response = $this->response->withStatus(201);
            } else {
                // Recolhe erros por índice para retornar ao cliente
                $errors = [];
                foreach ($entities as $index => $entity) {
                    $entityErrors = $entity->getErrors();
                    if (!empty($entityErrors)) {
                        $errors[$index] = $entityErrors;
                    }
                }
                $this->set([
                    'message' => 'Validation error on batch create',
                    'errors' => $errors,
                ]);
                $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
                $this->response = $this->response->withStatus(422);
            }

            return null;
        }

        // Single entity flow (compatibilidade)
        $inspectionItem = $this->InspectionItem->newEmptyEntity();
        $inspectionItem = $this->InspectionItem->patchEntity($inspectionItem, (array)$data);

        if ($this->InspectionItem->save($inspectionItem)) {

            $this->set([
                'inspectionItem' => $inspectionItem,
                'message' => 'Inspection Item created successfully',
            ]);
            $this->viewBuilder()->setOption('serialize', ['inspectionItem', 'message']);
            $this->response = $this->response->withStatus(201);
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