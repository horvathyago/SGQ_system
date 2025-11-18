<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry; // ESSENCIAL: Adicionar a importação do TableRegistry

/**
 * TemplateItem Controller
 *
 * @property \App\Model\Table\TemplateItemTable $TemplateItem
 */
class TemplateItemController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        
        // Carrega explicitamente a tabela Singular
        $this->TemplateItem = $this->fetchTable('TemplateItem');
    }

    public function index()
    {
        // Usa o Alias Singular definido no Table
        $query = $this->TemplateItem->find()
            ->contain(['ChecklistTemplate', 'ItemMaster']); // Aliases corretos

        $settings = [
            'limit' => 25,
        ];

        $templateItem = $this->paginate($query, $settings);

        $this->set(compact('templateItem'));
    }

    public function view(string $id = null)
    {
        if (!$id) {
            throw new RecordNotFoundException('Template item id is required');
        }

        // Usa o Alias Singular
        $templateItem = $this->TemplateItem->get($id, [
            'contain' => ['ChecklistTemplate', 'ItemMaster', 'InspectionItem'], // Aliases corretos
        ]);

        $this->set(compact('templateItem'));
    }

    public function add()
    {
        $templateItem = $this->TemplateItem->newEmptyEntity();

        if ($this->request->is('post')) {
            $templateItem = $this->TemplateItem->patchEntity($templateItem, $this->request->getData());

            if ($this->TemplateItem->save($templateItem)) {
                $this->Flash->success(__('The template item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to save template item. Try again.'));
        }

        // CORREÇÃO CRÍTICA: Carregar as Tabelas via TableRegistry para garantir o find('list')
        // Isso resolve o erro de "Undefined property" e garante o carregamento
        $checklistTemplateTable = TableRegistry::getTableLocator()->get('ChecklistTemplate');
        $itemMasterTable = TableRegistry::getTableLocator()->get('ItemMaster');

        // Busca as listas usando os Aliases corretos
        $checklistTemplateVersions = $checklistTemplateTable->find('list')->toArray();
        $itemMasters = $itemMasterTable->find('list')->toArray();

        // Envia para a View com os nomes das variáveis esperados pelo add.php
        $this->set(compact('templateItem', 'checklistTemplateVersions', 'itemMasters')); 
    }

    public function edit(string $id = null)
    {
        if (!$id) {
            throw new RecordNotFoundException('Template item id is required');
        }

        $templateItem = $this->TemplateItem->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $templateItem = $this->TemplateItem->patchEntity($templateItem, $this->request->getData());

            if ($this->TemplateItem->save($templateItem)) {
                $this->Flash->success(__('The template item has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to save template item.'));
        }

        // CORREÇÃO CRÍTICA: Carregar as Tabelas via TableRegistry
        $checklistTemplateTable = TableRegistry::getTableLocator()->get('ChecklistTemplate');
        $itemMasterTable = TableRegistry::getTableLocator()->get('ItemMaster');

        $checklistTemplateVersions = $checklistTemplateTable->find('list')->toArray();
        $itemMasters = $itemMasterTable->find('list')->toArray();

        // Envia para a View com os nomes das variáveis esperados
        $this->set(compact('templateItem', 'checklistTemplateVersions', 'itemMasters'));
    }

    public function delete(string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        if (!$id) {
            $this->Flash->error(__('Template item id is required.'));
            return $this->redirect(['action' => 'index']);
        }
        try {
            $templateItem = $this->TemplateItem->get($id);
            if ($this->TemplateItem->delete($templateItem)) {
                $this->Flash->success(__('Template item deleted.'));
            } else {
                $this->Flash->error(__('Unable to delete template item.'));
            }
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Template item not found.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}