<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\FrozenTime;
use Cake\View\JsonView;

/**
 * TemplateItem Controller (API)
 * Gerencia os passos individuais que compõem um Checklist.
 *
 * @property \App\Model\Table\TemplateItemTable $TemplateItem
 */
class TemplateItemController extends AppController
{
    /**
     * Define que este controller suporta respostas JSON nativas do CakePHP.
     */
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        
        // Configura a classe da View para Json
        $this->viewBuilder()->setClassName('Json');

        // REMOVIDO: $this->loadComponent('RequestHandler'); 
        // A lógica de negociação de view agora é feita via viewClasses e Accept header.

        // Remove o FlashComponent se estiver carregado, pois não é útil em API Stateless
        if ($this->components()->has('Flash')) {
            $this->components()->unload('Flash');
        }

        $this->TemplateItem = $this->fetchTable('TemplateItem');
    }

    /**
     * Rota: GET /template-item
     * Suporta query params: checklist_id, phase_id
     */
    public function index(): ?Response
    {
        $checklistId = $this->request->getQuery('checklist_id');
        $phaseId = $this->request->getQuery('phase_id');

        $query = $this->TemplateItem->find()
            ->contain(['ChecklistTemplate', 'ItemMaster'])
            ->order(['TemplateItem.ordem' => 'ASC']);

        if ($checklistId) {
            $query->where(['TemplateItem.checklist_template_id' => $checklistId]);
        }
        
        if ($phaseId) {
            $query->where(['TemplateItem.phase_id' => $phaseId]);
        }

        // Paginação ou lista completa dependendo da necessidade. 
        // Para API de checklist, geralmente queremos todos os itens da fase sem paginação estrita,
        // mas mantemos paginate para consistência. Aumentei o limite.
        $templateItems = $this->paginate($query, ['limit' => 100]);
        
        $this->set(compact('templateItems'));
        $this->viewBuilder()->setOption('serialize', 'templateItems');
        return null;
    }

    /**
     * Rota: GET /template-item/{id}
     */
    public function view(string $id = null): ?Response
    {
        try {
            $templateItem = $this->TemplateItem->get($id, [
                'contain' => ['ChecklistTemplate', 'ItemMaster', 'InspectionItem'],
            ]);
            $this->set(compact('templateItem'));
            $this->viewBuilder()->setOption('serialize', 'templateItem');
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Template item não encontrado.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }

    /**
     * Rota: POST /template-item
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $templateItem = $this->TemplateItem->newEmptyEntity();
        $data = $this->request->getData();

        if (empty($data['created_at'])) {
            $data['created_at'] = FrozenTime::now();
        }

        $templateItem = $this->TemplateItem->patchEntity($templateItem, $data);

        if ($this->TemplateItem->save($templateItem)) {
            $this->set([
                'templateItem' => $templateItem,
                'message' => 'Template item salvo com sucesso.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['templateItem', 'message']);
            $this->response = $this->response->withStatus(201);
        } else {
            $this->set([
                'message' => 'Erro de validação ao salvar template item.',
                'errors' => $templateItem->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: PUT/PATCH /template-item/{id}
     */
    public function edit(string $id = null): ?Response
    {
        $this->request->allowMethod(['patch', 'put']);

        try {
            $templateItem = $this->TemplateItem->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Template item não encontrado para edição.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return null;
        }

        $data = $this->request->getData();
        $templateItem = $this->TemplateItem->patchEntity($templateItem, $data);

        if ($this->TemplateItem->save($templateItem)) {
            $this->set([
                'templateItem' => $templateItem,
                'message' => 'Template item atualizado com sucesso.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['templateItem', 'message']);
            $this->response = $this->response->withStatus(200);
        } else {
            $this->set([
                'message' => 'Erro de validação ao atualizar.',
                'errors' => $templateItem->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: DELETE /template-item/{id}
     */
    public function delete(string $id = null): ?Response
    {
        $this->request->allowMethod(['delete']);

        try {
            $templateItem = $this->TemplateItem->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(204);
            return null;
        }

        if ($this->TemplateItem->delete($templateItem)) {
            $this->response = $this->response->withStatus(204);
        } else {
            $this->response = $this->response->withStatus(500);
            $this->set(['message' => 'Não foi possível remover o template item.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }
}