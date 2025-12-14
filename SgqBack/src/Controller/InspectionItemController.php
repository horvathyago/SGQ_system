<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\View\JsonView;

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
        
        // Remove Flash se existir
        if ($this->components()->has('Flash')) {
            $this->components()->unload('Flash');
        }
    }

    /**
     * Rota: GET /inspection-item/index.json
     */
    public function index(): ?Response
    {
        // 1. Força Cabeçalhos CORS manualmente para garantir que o erro seja legível no navegador
        $this->response = $this->response
            ->withHeader('Access-Control-Allow-Origin', '*') // Em produção use o domínio específico
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        try {
            // 2. Cria a Query básica
            $query = $this->InspectionItem->find();

            // 3. Verifica quais associações realmente existem antes de tentar o 'contain'
            // Isso evita o erro 500 se você não tiver a tabela CalibrationRecords ou TemplateItem criada
            $contains = [];
            
            // Verifica Inspection (Pai)
            if ($this->InspectionItem->hasAssociation('Inspection')) {
                $contains[] = 'Inspection';
            }
            
            // Verifica ItemMaster
            if ($this->InspectionItem->hasAssociation('ItemMaster')) {
                $contains[] = 'ItemMaster';
            }
            
            // Verifica TemplateItem
            if ($this->InspectionItem->hasAssociation('TemplateItem')) {
                $contains[] = 'TemplateItem';
            }
            
            // Verifica CalibrationRecords
            if ($this->InspectionItem->hasAssociation('CalibrationRecords')) {
                $contains[] = 'CalibrationRecords';
            }

            // Aplica os contains seguros
            $query->contain($contains);

            // Filtros
            $inspectionId = $this->request->getQuery('inspection_id');
            $phaseId = $this->request->getQuery('phase_id');

            if ($inspectionId) {
                // Usa alias genérico para evitar erro de coluna ambígua
                $query->where(['InspectionItem.inspection_id' => $inspectionId]);
            }

            if ($phaseId) {
                // Só tenta fazer o matching se a associação TemplateItem existir
                if ($this->InspectionItem->hasAssociation('TemplateItem')) {
                    $query->matching('TemplateItem', function ($q) use ($phaseId) {
                        return $q->where(['TemplateItem.phase_id' => $phaseId]);
                    });
                }
            }

            $query->order(['InspectionItem.ordem' => 'ASC']);

            $inspectionItems = $this->paginate($query);

            $this->set(compact('inspectionItems'));
            $this->viewBuilder()->setOption('serialize', 'inspectionItems');

        } catch (\Throwable $e) {
            // 🚨 CAPTURA O ERRO FATAL E RETORNA JSON
            $this->response = $this->response->withStatus(500);
            
            $errorResponse = [
                'STATUS' => 'ERRO FATAL NO BACKEND',
                'message' => $e->getMessage(), // AQUI ESTARÁ A CAUSA REAL
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            
            $this->set(['error' => $errorResponse]);
            $this->viewBuilder()->setOption('serialize', ['error']);
        }
        
        return null;
    }

    // ... (Mantenha os métodos add, edit, delete como estavam, mas verifique o contain no view)

    public function view($id = null): ?Response
    {
        try {
            // 🚨 CORREÇÃO NO CONTAIN
            $inspectionItem = $this->InspectionItem->get($id, [
                'contain' => ['Inspection', 'ItemMaster', 'TemplateItem', 'CalibrationRecords', 'NonConformity']
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
    
    // ... restante do código (add, edit, delete) permanece igual ao anterior ...
    /**
     * Rota: POST /inspection-item
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        if (is_array($data) && array_values($data) === $data) {
            $entities = $this->InspectionItem->newEntities($data);
            $saved = $this->InspectionItem->saveMany($entities);

            if ($saved !== false) {
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

        // Single entity flow
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