<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;

/**
 * @property \App\Model\Table\TemplateItemTable $TemplateItem
 */
class TemplateItemController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');

        // garante tipagem para IDEs
        $this->TemplateItem = $this->fetchTable('TemplateItem');
    }

    public function index()
    {
        $query = $this->TemplateItem->find()
            ->contain(['ChecklistTemplate', 'ItemMaster'])
            ->order(['TemplateItem.ordem' => 'ASC']);

        $templateItem = $this->paginate($query, ['limit' => 25]);
        $this->set(compact('templateItem'));
    }

    public function view(string $id = null)
    {
        if (!$id) {
            throw new RecordNotFoundException('ID é obrigatório.');
        }

        $templateItem = $this->TemplateItem->get($id, [
            'contain' => ['ChecklistTemplate', 'ItemMaster', 'InspectionItem'],
        ]);

        $this->set(compact('templateItem'));
    }

    public function add()
    {
        $templateItem = $this->TemplateItem->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // created_at: se não vier, gera automaticamente
            if (empty($data['created_at'])) {
                $data['created_at'] = FrozenTime::now();
            }

            $templateItem = $this->TemplateItem->patchEntity($templateItem, $data);

            // Se validation/buildRules falharem, $templateItem terá erros
            if ($this->TemplateItem->save($templateItem)) {
                $this->Flash->success('Template item salvo com sucesso.');
                return $this->redirect(['action' => 'index']);
            }

            // Mostra mensagens de validação (útil para debugging)
            $errors = $templateItem->getErrors();
            if (!empty($errors)) {
                $this->Flash->error('Erro ao salvar: ' . json_encode($errors));
            } else {
                $this->Flash->error('Erro desconhecido ao salvar template item.');
            }
        }

        // Carrega listas para a view: as chaves e nomes corretos
        $checklistTemplateTable = TableRegistry::getTableLocator()->get('ChecklistTemplate');
        $itemMasterTable = TableRegistry::getTableLocator()->get('ItemMaster');

        // Detecta o campo de exibição (valueField) para cada tabela de forma segura:
        $checklistDisplay = $this->_detectDisplayField($checklistTemplateTable, ['name', 'title', 'descricao']);
        $itemMasterDisplay = $this->_detectDisplayField($itemMasterTable, ['title', 'name', 'nome']);

        $checklistTemplateVersions = $checklistTemplateTable->find('list', [
            'keyField' => 'id',
            'valueField' => $checklistDisplay
        ])->toArray();

        $itemMasters = $itemMasterTable->find('list', [
            'keyField' => 'id',
            'valueField' => $itemMasterDisplay
        ])->toArray();

        $this->set(compact('templateItem', 'checklistTemplateVersions', 'itemMasters'));
    }

    public function edit(string $id = null)
    {
        if (!$id) {
            throw new RecordNotFoundException('ID é obrigatório.');
        }

        $templateItem = $this->TemplateItem->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $templateItem = $this->TemplateItem->patchEntity($templateItem, $data);

            if ($this->TemplateItem->save($templateItem)) {
                $this->Flash->success('Template item atualizado com sucesso.');
                return $this->redirect(['action' => 'index']);
            }

            $errors = $templateItem->getErrors();
            if (!empty($errors)) {
                $this->Flash->error('Erro ao atualizar: ' . json_encode($errors));
            } else {
                $this->Flash->error('Erro desconhecido ao atualizar.');
            }
        }

        // Reusar a lógica de carregamento de listas
        $checklistTemplateTable = TableRegistry::getTableLocator()->get('ChecklistTemplate');
        $itemMasterTable = TableRegistry::getTableLocator()->get('ItemMaster');

        $checklistDisplay = $this->_detectDisplayField($checklistTemplateTable, ['name', 'title', 'descricao']);
        $itemMasterDisplay = $this->_detectDisplayField($itemMasterTable, ['title', 'name', 'nome']);

        $checklistTemplateVersions = $checklistTemplateTable->find('list', [
            'keyField' => 'id',
            'valueField' => $checklistDisplay
        ])->toArray();

        $itemMasters = $itemMasterTable->find('list', [
            'keyField' => 'id',
            'valueField' => $itemMasterDisplay
        ])->toArray();

        $this->set(compact('templateItem', 'checklistTemplateVersions', 'itemMasters'));
    }

    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        if (!$id) {
            $this->Flash->error('ID é obrigatório.');
            return $this->redirect(['action' => 'index']);
        }

        try {
            $templateItem = $this->TemplateItem->get($id);
            if ($this->TemplateItem->delete($templateItem)) {
                $this->Flash->success('Template item removido.');
            } else {
                $this->Flash->error('Não foi possível remover o template item.');
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error('Template item não encontrado.');
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Helper privado: detecta um campo de exibição disponível (valueField)
     */
    private function _detectDisplayField($table, array $candidates = [])
    {
        $schema = $table->getSchema();
        $cols = $schema->columns();

        foreach ($candidates as $c) {
            if (in_array($c, $cols)) {
                return $c;
            }
        }

        // fallback: primeiro string/text column
        foreach ($cols as $col) {
            $type = $schema->getColumnType($col);
            if ($type === 'string' || $type === 'text') {
                return $col;
            }
        }

        return 'id';
    }
}
