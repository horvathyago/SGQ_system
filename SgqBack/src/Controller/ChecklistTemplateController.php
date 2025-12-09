<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;

/**
 * ChecklistTemplate Controller
 *
 * @property \App\Model\Table\ChecklistTemplateTable $ChecklistTemplate
 */
class ChecklistTemplateController extends AppController
{
    public function index()
    {
        $query = $this->ChecklistTemplate->find();
        $checklistTemplate = $this->paginate($query);

        $this->set(compact('checklistTemplate'));
    }

    public function view($id = null)
    {
        $checklistTemplate = $this->ChecklistTemplate->get($id, contain: [
            'ChecklistTemplateVersion',
            'Inspection',
            'ProductFamilyChecklist'
        ]);

        $this->set(compact('checklistTemplate'));
    }

    public function add()
    {
        $checklistTemplate = $this->ChecklistTemplate->newEmptyEntity();

        if ($this->request->is('post')) {
            $checklistTemplate = $this->ChecklistTemplate->patchEntity($checklistTemplate, $this->request->getData());

            if ($this->ChecklistTemplate->save($checklistTemplate)) {
                $this->Flash->success(__('The checklist template has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The checklist template could not be saved. Please, try again.'));
        }

        $this->set(compact('checklistTemplate'));
    }

    public function edit($id = null)
    {
        $checklistTemplate = $this->ChecklistTemplate->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            // Atualiza dados normais
            $checklistTemplate = $this->ChecklistTemplate->patchEntity($checklistTemplate, $data);

            if ($this->ChecklistTemplate->save($checklistTemplate)) {

                // Criar nova versão
                if (!empty($data['criar_versao']) && $data['criar_versao'] == 1) {

                    try {
                        $conn = \Cake\Datasource\ConnectionManager::get('default');

                        // EVITA ERRO DO INTELEPHENSE
                        $driver = $conn->getDriver();
                        $stmt = $driver->prepare("CALL criar_nova_versao_checklist(:id)");
                        $stmt->bindValue('id', $id, 'string');
                        $stmt->execute();

                        $this->Flash->success('Alterações salvas e nova versão criada!');

                    } catch (\Exception $e) {
                        $this->Flash->error('Erro ao criar versão: ' . $e->getMessage());
                    }

                } else {
                    $this->Flash->success('Alterações salvas com sucesso.');
                }

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The checklist template could not be saved. Please, try again.'));
        }

        $this->set(compact('checklistTemplate'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $checklistTemplate = $this->ChecklistTemplate->get($id);

        if ($this->ChecklistTemplate->delete($checklistTemplate)) {
            $this->Flash->success(__('The checklist template has been deleted.'));
        } else {
            $this->Flash->error(__('The checklist template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
