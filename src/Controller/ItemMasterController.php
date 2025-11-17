<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Database\Connection;

/**
 * ItemMaster Controller
 *
 * @property \App\Model\Table\ItemMasterTable $ItemMaster
 */
class ItemMasterController extends AppController
{
    public function index()
    {
        $query = $this->ItemMaster->find();
        $itemMaster = $this->paginate($query);

        $this->set(compact('itemMaster'));
    }

    public function view($id = null)
    {
        $itemMaster = $this->ItemMaster->get($id, contain: [
            'InspectionItem',
            'ItemMasterVersion',
            'TemplateItem'
        ]);

        $this->set(compact('itemMaster'));
    }

    public function add()
    {
        $itemMaster = $this->ItemMaster->newEmptyEntity();

        if ($this->request->is('post')) {

            $itemMaster = $this->ItemMaster->patchEntity($itemMaster, $this->request->getData());

            if ($this->ItemMaster->save($itemMaster)) {
                $this->Flash->success('The item master has been saved.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('The item master could not be saved. Please, try again.');
        }

        $this->set(compact('itemMaster'));
    }

    public function edit($id = null)
    {
        $itemMaster = $this->ItemMaster->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            // Salva alterações normais
            $itemMaster = $this->ItemMaster->patchEntity($itemMaster, $data);

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

                        $this->Flash->success('Alterações salvas e nova versão criada!');

                    } catch (\Exception $e) {
                        $this->Flash->error('Erro ao criar nova versão: ' . $e->getMessage());
                    }

                } else {
                    $this->Flash->success('Alterações salvas sem criar nova versão.');
                }

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Não foi possível salvar o item.');
        }

        $this->set(compact('itemMaster'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $itemMaster = $this->ItemMaster->get($id);

        if ($this->ItemMaster->delete($itemMaster)) {
            $this->Flash->success('The item master has been deleted.');
        } else {
            $this->Flash->error('The item master could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'index']);
    }
}
