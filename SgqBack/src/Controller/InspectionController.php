<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response; 
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\View\JsonView; // Importar o JsonView

/**
 * Inspection Controller (API)
 *
 * @property \App\Model\Table\InspectionTable $Inspection
 */
class InspectionController extends AppController
{
    // 1. 🎯 CORREÇÃO: Usa viewClasses para dizer ao CakePHP para carregar o JsonView
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        
        // 🚨 O RequestHandlerComponent FOI REMOVIDO DAQUI
        
        // Configura a view padrão como JsonView
        $this->viewBuilder()->setClassName('Json'); 
        
        // Desabilita o FlashComponent
        if ($this->components()->has('Flash')) {
            $this->loadComponent('Flash')->setConfig('allowedActions', []);
        }
    }

    /**
     * Rota: GET /inspection
     * Retorna a lista de Inspeções.
     */
    public function index(): ?Response
    {
        // Nota: O método paginate() funciona automaticamente
        $query = $this->Inspection->find()
            ->contain(['ProductionOrders', 'ChecklistTemplates', 'ChecklistTemplateVersions', 'Inspectors']);
        $inspection = $this->paginate($query);

        $this->set(compact('inspection'));
        $this->viewBuilder()->setOption('serialize', 'inspection');
        return null;
    }

    /**
     * Rota: GET /inspection/{id}
     * Retorna os detalhes de uma Inspeção específica.
     */
    public function view($id = null): ?Response
    {
        try {
            $inspection = $this->Inspection->get($id, [
                'contain' => ['ProductionOrders', 'ChecklistTemplates', 'ChecklistTemplateVersions', 'Inspectors', 'InspectionItem'],
            ]);

            $this->set(compact('inspection'));
            $this->viewBuilder()->setOption('serialize', 'inspection');
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Inspeção não encontrada.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }

    /**
     * Rota: POST /inspection
     * Cria uma nova Inspeção.
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $inspection = $this->Inspection->newEmptyEntity();
        $inspection = $this->Inspection->patchEntity($inspection, $this->request->getData());
        
        if ($this->Inspection->save($inspection)) {
            
            $this->set([
                'inspection' => $inspection,
                'message' => 'Inspeção criada com sucesso.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['inspection', 'message']);
            $this->response = $this->response->withStatus(201); // 201 Created
        } else {
            $this->set([
                'message' => 'Erro de validação ao criar inspeção.',
                'errors' => $inspection->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422); // 422 Unprocessable Entity
        }
        return null;
    }

    /**
     * Rota: PUT/PATCH /inspection/{id}
     * Edita uma Inspeção existente.
     */
    public function edit($id = null): ?Response
    {
        $this->request->allowMethod(['patch', 'put']);

        try {
            $inspection = $this->Inspection->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Inspeção não encontrada para edição.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return null;
        }

        $inspection = $this->Inspection->patchEntity($inspection, $this->request->getData());
        
        if ($this->Inspection->save($inspection)) {
            
            $this->set([
                'inspection' => $inspection,
                'message' => 'Inspeção atualizada com sucesso.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['inspection', 'message']);
            $this->response = $this->response->withStatus(200); // 200 OK
        } else {
            $this->set([
                'message' => 'Erro de validação ao atualizar inspeção.',
                'errors' => $inspection->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: DELETE /inspection/{id}
     * Deleta uma Inspeção.
     */
    public function delete($id = null): ?Response
    {
        $this->request->allowMethod(['delete']);

        try {
            $inspection = $this->Inspection->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(204); // 204 No Content (Já não existe)
            return null;
        }

        if ($this->Inspection->delete($inspection)) {
            $this->response = $this->response->withStatus(204); // 204 No Content (Sucesso)
        } else {
            $this->response = $this->response->withStatus(500);
            $this->set(['message' => 'Não foi possível remover a inspeção.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }
}