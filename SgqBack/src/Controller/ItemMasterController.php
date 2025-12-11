<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response; 
use Cake\Datasource\ConnectionManager;
use Cake\Database\Connection;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\View\JsonView;

/**
 * ItemMaster Controller (API)
 *
 * @property \App\Model\Table\ItemMasterTable $ItemMaster
 */
class ItemMasterController extends AppController
{
    // 1. Configura a view padrão para JSON
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();
        // Remove RequestHandlerComponent e dependências de Flash/Redirects
        $this->viewBuilder()->setClassName('Json');

        if ($this->components()->has('Flash')) {
            $this->loadComponent('Flash')->setConfig('allowedActions', []);
        }
        
        // 🚨 CORREÇÃO CRÍTICA: Inicializar a propriedade do Model para resolver o 'find() on null'
        $this->ItemMaster = $this->fetchTable('ItemMaster');
    }

    /**
     * Rota: GET /item-master
     * Retorna a lista de itens mestre.
     */
    public function index(): ?Response
    {
        // 🚨 CORREÇÃO: Removendo o uso de $this->paginate()
        // Isso garante que o CakePHP retorne o array puro de entidades,
        // eliminando a complexidade do objeto de paginação (paging: { data: [...] }).
        
        $itemMaster = $this->ItemMaster->find('all')
                                       ->toArray(); // Converte o Query Builder diretamente para um array

        $this->set(compact('itemMaster'));
        // Agora, o JSON retornado será: { "itemMaster": [ {item1}, {item2}, ... ] }
        $this->viewBuilder()->setOption('serialize', 'itemMaster');
        return null;
    }

    /**
     * Rota: GET /item-master/{id}
     * Retorna os detalhes de um item mestre.
     */
    public function view($id = null): ?Response
    {
        try {
            $itemMaster = $this->ItemMaster->get($id, [
                'contain' => [
                    'InspectionItem',
                    'ItemMasterVersion',
                    'TemplateItem'
                ]
            ]);

            $this->set(compact('itemMaster'));
            $this->viewBuilder()->setOption('serialize', 'itemMaster');
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Item Mestre não encontrado.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }

    /**
     * Rota: POST /item-master
     * Cria um novo item mestre.
     */
    public function add(): ?Response
    {
        $this->request->allowMethod(['post']);

        $itemMaster = $this->ItemMaster->newEmptyEntity();
        $itemMaster = $this->ItemMaster->patchEntity($itemMaster, $this->request->getData());

        if ($this->ItemMaster->save($itemMaster)) {
            $this->set([
                'itemMaster' => $itemMaster,
                'message' => 'Item Mestre salvo com sucesso.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['itemMaster', 'message']);
            $this->response = $this->response->withStatus(201); // 201 Created
        } else {
            $this->set([
                'message' => 'Erro de validação ao salvar item mestre.',
                'errors' => $itemMaster->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422); // 422 Unprocessable Entity
        }
        return null;
    }

    /**
     * Rota: PUT/PATCH /item-master/{id}
     * Edita um item mestre e gerencia a criação de nova versão (Stored Procedure).
     */
    public function edit($id = null): ?Response
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        try {
            $itemMaster = $this->ItemMaster->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Item Mestre não encontrado para edição.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return null;
        }

        $data = $this->request->getData();
        $itemMaster = $this->ItemMaster->patchEntity($itemMaster, $data);
        
        $newVersionCreated = false;

        if ($this->ItemMaster->save($itemMaster)) {

            // Verifica se deve criar nova versão
            if (!empty($data['criar_versao']) && $data['criar_versao'] == 1) {
                try {
                    /** @var Connection $conn */
                    $conn = ConnectionManager::get('default');

                    // Chama a procedure via driver (forma correta no CakePHP 5)
                    $stmt = $conn->getDriver()->prepare(
                        "CALL criar_nova_versao_item(:id)"
                    );

                    $stmt->bindValue('id', $id);
                    $stmt->execute();

                    $newVersionCreated = true;

                } catch (\Exception $e) {
                    // Erro na procedure: retorna 400, mas o item base JÁ foi salvo (200)
                    $this->set([
                        'message' => 'Alterações salvas, mas houve um erro ao criar a nova versão.',
                        'error_detail' => $e->getMessage(),
                    ]);
                    $this->viewBuilder()->setOption('serialize', ['message', 'error_detail']);
                    $this->response = $this->response->withStatus(400);
                    return null;
                }
            }

            $message = $newVersionCreated ? 'Alterações salvas e nova versão criada!' : 'Alterações salvas com sucesso.';

            $this->set([
                'itemMaster' => $itemMaster,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['itemMaster', 'message']);
            $this->response = $this->response->withStatus(200);
        } else {
            $this->set([
                'message' => 'Erro de validação ao salvar o item.',
                'errors' => $itemMaster->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);
        }

        return null;
    }

    /**
     * Rota: DELETE /item-master/{id}
     * Deleta um item mestre.
     */
    public function delete($id = null): ?Response
    {
        $this->request->allowMethod(['delete']);

        try {
            $itemMaster = $this->ItemMaster->get($id);
        } catch (RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(204); // 204 No Content (Já removido)
            return null;
        }

        if ($this->ItemMaster->delete($itemMaster)) {
            $this->response = $this->response->withStatus(204); // 204 No Content (Sucesso)
        } else {
            $this->response = $this->response->withStatus(500);
            $this->set(['message' => 'Não foi possível remover o item mestre.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
        return null;
    }
}