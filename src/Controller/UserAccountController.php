<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * UserAccount Controller
 *
 * @property \App\Model\Table\UserAccountTable $UserAccount
 */
class UserAccountController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();

        // Carrega o componente corretamente
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Permitir acesso às ações de 'login' e 'add' sem autenticação
        $this->Authentication->allowUnauthenticated(array('logout', 'login'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->UserAccount->find();
        $userAccount = $this->paginate($query);

        $this->set(compact('userAccount'));
    }

    /**
     * View method
     *
     * @param string|null $id User Account id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userAccount = $this->UserAccount->get($id, contain: []);
        $this->set(compact('userAccount'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // Carrega a tabela corretamente
        $UserAccounts = $this->fetchTable('UserAccount');

        // Cria nova entidade vazia
        $userAccount = $UserAccounts->newEmptyEntity();

        // Autoriza a ação
        $this->Authorization->authorize($userAccount);

        if ($this->request->is('post')) {
            // Preenche com dados enviados
            $userAccount = $UserAccounts->patchEntity($userAccount, $this->request->getData());

            if ($UserAccounts->save($userAccount)) {
                $this->Flash->success('Conta criada com sucesso.');
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Erro ao criar conta. Verifique os dados e tente novamente.');
        }

        $this->set(compact('userAccount'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User Account id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userAccount = $this->UserAccount->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userAccount = $this->UserAccount->patchEntity($userAccount, $this->request->getData());
            if ($this->UserAccount->save($userAccount)) {
                $this->Flash->success(__('The user account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user account could not be saved. Please, try again.'));
        }
        $this->set(compact('userAccount'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Account id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userAccount = $this->UserAccount->get($id);
        if ($this->UserAccount->delete($userAccount)) {
            $this->Flash->success(__('The user account has been deleted.'));
        } else {
            $this->Flash->error(__('The user account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setTemplatePath('UserAccount')->setTemplate('login');
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
    
        if($this->request->is('post') && !$result->isValid()) {
            $this->Flash->bootstrap('usuario ou senha inválidos', array('key' => 'danger'));
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->Authentication->logout();
        $this->redirect('/UserAccount/login');
    }
    
}
