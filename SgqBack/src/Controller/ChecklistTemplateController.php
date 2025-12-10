<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\View\JsonView;

/**
 * ChecklistTemplate Controller (API)
 *
 * @property \App\Model\Table\ChecklistTemplateTable $ChecklistTemplate
 */
class ChecklistTemplateController extends AppController
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
     * Rota: GET /checklist-template
     */
    public function index(): ?Response
    {
        $query = $this->ChecklistTemplate->find();
        $checklistTemplate = $this->paginate($query);

        $this->set(compact('checklistTemplate'));
        $this->viewBuilder()->setOption('serialize', 'checklistTemplate');
        return null;
    }

    /**
     * Rota: GET /checklist-template/{id}
     */
    public function view($id = null): ?Response
    {
        try {
            $checklistTemplate = $this->ChecklistTemplate->get($id, [
                'contain' => ['ChecklistTemplateVersion', 'Inspection', 'ProductFamilyChecklist'],
            ]);

            $this->set(compact('checklistTemplate'));
            $this->viewBuilder()->setOption('serialize', 'checklistTemplate');
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Checklist Template not found']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }

    /**
     * Rota: POST /checklist-template
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $checklistTemplate = $this->ChecklistTemplate->newEmptyEntity();
        $checklistTemplate = $this->ChecklistTemplate->patchEntity($checklistTemplate, $this->request->getData());

        if ($this->ChecklistTemplate->save($checklistTemplate)) {
            $this->set([
                'checklistTemplate' => $checklistTemplate,
                'message' => 'Checklist Template created successfully',
            ]);
            $this->viewBuilder()->setOption('serialize', ['checklistTemplate', 'message']);
            $this->response = $this->response->withStatus(201);
        } else {
            $this->set([
                'message' => 'Validation error',
                'errors' => $checklistTemplate->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: PUT/PATCH /checklist-template/{id}
     */
    public function edit($id = null): ?Response
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        try {
            $checklistTemplate = $this->ChecklistTemplate->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Checklist Template not found for editing']);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return null;
        }

        $data = $this->request->getData();
        $checklistTemplate = $this->ChecklistTemplate->patchEntity($checklistTemplate, $data);

        $newVersionCreated = false;
        
        if ($this->ChecklistTemplate->save($checklistTemplate)) {
            
            if (!empty($data['criar_versao']) && $data['criar_versao'] == 1) {
                try {
                    $conn = ConnectionManager::get('default');
                    $stmt = $conn->getDriver()->prepare("CALL criar_nova_versao_checklist(:id)");
                    $stmt->bindValue('id', $id, 'string');
                    $stmt->execute();
                    $newVersionCreated = true;
                } catch (\Exception $e) {
                    $this->set([
                        'message' => 'Template updated, but error creating new version.',
                        'error_detail' => $e->getMessage(),
                    ]);
                    $this->viewBuilder()->setOption('serialize', ['message', 'error_detail']);
                    $this->response = $this->response->withStatus(400); 
                    return null;
                }
            }
            
            $message = $newVersionCreated ? 'Template updated and new version created.' : 'Template updated successfully.';
            
            $this->set([
                'checklistTemplate' => $checklistTemplate,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['checklistTemplate', 'message']);
            $this->response = $this->response->withStatus(200);
        } else {
             $this->set([
                'message' => 'Validation error',
                'errors' => $checklistTemplate->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: DELETE /checklist-template/{id}
     */
    public function delete($id = null): ?Response
    {
        $this->request->allowMethod(['delete']);

        try {
            $checklistTemplate = $this->ChecklistTemplate->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(204);
            return null;
        }

        if ($this->ChecklistTemplate->delete($checklistTemplate)) {
            $this->response = $this->response->withStatus(204);
        } else {
            $this->response = $this->response->withStatus(500);
            $this->set(['message' => 'Checklist Template could not be deleted']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }
}