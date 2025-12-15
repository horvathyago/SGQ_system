<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\View\JsonView;

/**
 * NonConformity Controller
 *
 * @property \App\Model\Table\NonConformityTable $NonConformity
 */
class NonConformityController extends AppController
{
    // Define que este controller deve carregar o JsonView para serialização
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        
        // Configura a view padrão como JsonView
        $this->viewBuilder()->setClassName('Json'); 
        
        // Desabilita o FlashComponent para APIs, pois não usamos sessão para mensagens
        if ($this->components()->has('Flash')) {
            $this->loadComponent('Flash')->setConfig('allowedActions', []);
        }
    }

    /**
     * Rota: GET /non-conformity
     * Retorna lista de Não Conformidades
     */
    public function index(): ?Response
    {
        $query = $this->NonConformity->find()
            ->contain(['InspectionItems', 'Responsavels']); // Mantive os contains originais
        
        $nonConformity = $this->paginate($query);

        $this->set(compact('nonConformity'));
        $this->viewBuilder()->setOption('serialize', 'nonConformity');
        return null;
    }

    /**
     * Rota: GET /non-conformity/{id}
     * Retorna detalhes de uma Não Conformidade específica
     */
    public function view($id = null): ?Response
    {
        try {
            // Mantive o contain do MrbAction que estava no seu original
            $nonConformity = $this->NonConformity->get($id, [
                'contain' => ['InspectionItems', 'Responsavels', 'MrbAction']
            ]);

            $this->set(compact('nonConformity'));
            $this->viewBuilder()->setOption('serialize', 'nonConformity');
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Não Conformidade não encontrada.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }

    /**
     * Rota: POST /non-conformity
     * Cria uma nova Não Conformidade
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $nonConformity = $this->NonConformity->newEmptyEntity();
        $nonConformity = $this->NonConformity->patchEntity($nonConformity, $this->request->getData());
        
        if ($this->NonConformity->save($nonConformity)) {
            $this->set([
                'nonConformity' => $nonConformity,
                'message' => 'Não Conformidade registrada com sucesso.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['nonConformity', 'message']);
            $this->response = $this->response->withStatus(201); // 201 Created
        } else {
            $this->set([
                'message' => 'Erro de validação ao salvar não conformidade.',
                'errors' => $nonConformity->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422); // 422 Unprocessable Entity
        }
        return null;
    }

    /**
     * Rota: PUT/PATCH /non-conformity/{id}
     * Edita uma Não Conformidade existente
     */
    public function edit($id = null): ?Response
    {
        $this->request->allowMethod(['patch', 'put']);

        try {
            $nonConformity = $this->NonConformity->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Registro não encontrado para edição.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return null;
        }

        $nonConformity = $this->NonConformity->patchEntity($nonConformity, $this->request->getData());
        
        if ($this->NonConformity->save($nonConformity)) {
            $this->set([
                'nonConformity' => $nonConformity,
                'message' => 'Não Conformidade atualizada com sucesso.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['nonConformity', 'message']);
            $this->response = $this->response->withStatus(200); // 200 OK
        } else {
            $this->set([
                'message' => 'Erro de validação ao atualizar.',
                'errors' => $nonConformity->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }
        return null;
    }

    /**
     * Rota: DELETE /non-conformity/{id}
     * Deleta uma Não Conformidade
     */
    public function delete($id = null): ?Response
    {
        $this->request->allowMethod(['delete']);

        try {
            $nonConformity = $this->NonConformity->get($id);
        } catch (RecordNotFoundException $e) {
            // Se já não existe, retorna 204 (sucesso sem conteúdo)
            $this->response = $this->response->withStatus(204); 
            return null;
        }

        if ($this->NonConformity->delete($nonConformity)) {
            $this->response = $this->response->withStatus(204);
        } else {
            $this->response = $this->response->withStatus(500);
            $this->set(['message' => 'Não foi possível remover o registro.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }
}