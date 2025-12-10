<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response; // Importação essencial para tipagem
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
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->viewBuilder()->setClassName('Json');

        // Remove o FlashComponent, pois ele é inútil em API
        $this->components()->has('Flash') ? $this->components()->unload('Flash') : null;

        // Garante a injeção do modelo (já estava correto)
        $this->TemplateItem = $this->fetchTable('TemplateItem');
    }
    
    // O método privado _detectDisplayField e a lógica de carregamento de listas para views
    // foram removidos daqui, pois não são apropriados para controladores de API.

    /**
     * Rota: GET /template-item
     * Lista todos os Itens de Template.
     */
    public function index(): ?Response
    {
        $query = $this->TemplateItem->find()
            ->contain(['ChecklistTemplate', 'ItemMaster'])
            ->order(['TemplateItem.ordem' => 'ASC']);

        $templateItem = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('templateItem'));
        $this->viewBuilder()->setOption('serialize', 'templateItem');
        return null;
    }

    /**
     * Rota: GET /template-item/{id}
     * Visualiza um Item de Template específico.
     */
    public function view(string $id = null): ?Response
    {
        try {
            // O check 'if (!$id)' é resolvido pela exceção get() se o ID for inválido
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
     * Cria um novo Item de Template.
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $templateItem = $this->TemplateItem->newEmptyEntity();
        $data = $this->request->getData();

        // created_at: se não vier, gera automaticamente
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
            $this->response = $this->response->withStatus(201); // 201 Created
        } else {
            // Erro de validação
            $this->set([
                'message' => 'Erro de validação ao salvar template item.',
                'errors' => $templateItem->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422); // 422 Unprocessable Entity
        }
        return null;
    }

    /**
     * Rota: PUT/PATCH /template-item/{id}
     * Edita um Item de Template existente.
     */
    public function edit(string $id = null): ?Response
    {
        $this->request->allowMethod(['patch', 'put']);

        try {
            // O check 'if (!$id)' é resolvido pela exceção get() se o ID for inválido
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
            $this->response = $this->response->withStatus(200); // 200 OK
        } else {
            // Erro de validação
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
     * Deleta um Item de Template.
     */
    public function delete(string $id = null): ?Response
    {
        $this->request->allowMethod(['delete']);

        try {
            // O check 'if (!$id)' é resolvido pela exceção get() se o ID for inválido
            $templateItem = $this->TemplateItem->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(204); // 204 No Content (Já removido)
            return null;
        }

        if ($this->TemplateItem->delete($templateItem)) {
            $this->response = $this->response->withStatus(204); // 204 No Content (Sucesso)
        } else {
            $this->response = $this->response->withStatus(500);
            $this->set(['message' => 'Não foi possível remover o template item.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }
}