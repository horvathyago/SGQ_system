<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\View\JsonView;

/**
 * UserAccount Controller
 *
 * @property \App\Model\Table\UserAccountTable $UserAccount
 * @property \Cake\Controller\Component\Authentication\AuthenticationComponent $Authentication
 * @property \Cake\Controller\Component\FormProtectionComponent $FormProtection
 * @property \Cake\Controller\Component\Authorization\AuthorizationComponent $Authorization
 */
class UserAccountController extends AppController
{
    // 1. Configura a view padrão para JSON
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function initialize(): void
    {
        parent::initialize();

        // Carrega o componente de Autenticação
        $this->loadComponent('Authentication.Authentication');
        
        // Define a view como JSON explicitamente
        $this->viewBuilder()->setClassName('Json'); 
        
        // Desabilita o FlashComponent (Não usado em API)
        if ($this->components()->has('Flash')) {
            $this->loadComponent('Flash')->setConfig('allowedActions', []);
        }
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Permite acesso às ações de 'login', 'logout' e 'add' sem autenticação
        $this->Authentication->allowUnauthenticated(['logout', 'login', 'add']);
        
        // Desabilita FormProtection/CSRF para ações de API
        if ($this->components()->has('FormProtection')) {
             $this->FormProtection->setConfig('unlockedActions', ['add', 'edit', 'delete', 'login', 'logout']);
        }

        // 🌟 CORREÇÃO CRÍTICA PARA O ERRO 405 (MÉTODO NÃO PERMITIDO APÓS REDIRECT) 🌟
        if ($this->request->is('json')) {
            $this->Authentication->setConfig('unauthenticatedRedirect', null);
            $this->Authentication->setConfig('unauthenticatedResponse', function () {
                return $this->response
                    ->withStatus(401)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['message' => 'Autenticação necessária.']));
            });
        }
    }

    // -------------------------------------------------------------------------
    // AÇÕES RESTful BÁSICAS (GET)
    // -------------------------------------------------------------------------

    /**
     * Index method (GET /user-accounts.json)
     */
    public function index()
    {
        $query = $this->UserAccount->find();
        $userAccounts = $this->paginate($query);

        $this->set(compact('userAccounts'));
        $this->viewBuilder()->setOption('serialize', ['userAccounts']);
    }

    /**
     * View method (GET /user-accounts/1.json)
     */
    public function view($id = null)
    {
        try {
            $userAccount = $this->UserAccount->get($id, contain: []);
            $this->set(compact('userAccount'));
            $this->viewBuilder()->setOption('serialize', ['userAccount']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Usuário não encontrado.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
    }

    // -------------------------------------------------------------------------
    // AÇÕES RESTful COM allowMethod (POST, PATCH, PUT, DELETE)
    // -------------------------------------------------------------------------

    /**
     * Add method (POST /user-accounts.json)
     */
    public function add()
    {
        $this->request->allowMethod(['post']);

        $userAccount = $this->UserAccount->newEmptyEntity();
        if ($this->components()->has('Authorization')) {
            $this->Authorization->authorize($userAccount, 'create');
        }

        $userAccount = $this->UserAccount->patchEntity($userAccount, $this->request->getData());

        if ($this->UserAccount->save($userAccount)) {
            // SUCESSO: Retorna status 201 Created
            $this->set('userAccount', $userAccount);
            $this->viewBuilder()->setOption('serialize', ['userAccount']);
            $this->response = $this->response->withStatus(201); 
            return;
        }

        // FALHA NA VALIDAÇÃO: Retorna status 422 Unprocessable Entity
        $this->set('errors', $userAccount->getErrors());
        $this->set(['message' => 'Erro de validação.']);
        $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
        $this->response = $this->response->withStatus(422);
    }


    /**
     * Edit method (PATCH/PUT /user-accounts/1.json)
     */
    public function edit($id = null)
    {
        // Apenas PATCH e PUT
        $this->request->allowMethod(['patch', 'put']);
        
        try {
            $userAccount = $this->UserAccount->get($id, contain: []);
            
            if ($this->components()->has('Authorization')) {
                $this->Authorization->authorize($userAccount, 'update');
            }

            $userAccount = $this->UserAccount->patchEntity($userAccount, $this->request->getData());
            
            if ($this->UserAccount->save($userAccount)) {
                // SUCESSO: Retorna o usuário atualizado com status 200 OK
                $this->set('userAccount', $userAccount);
                $this->viewBuilder()->setOption('serialize', ['userAccount']);
                $this->response = $this->response->withStatus(200);
                return;
            } 
            
            // FALHA NA VALIDAÇÃO: Retorna erros e status 422
            $this->set('errors', $userAccount->getErrors());
            $this->set(['message' => 'Erro de validação na atualização.']);
            $this->viewBuilder()->setOption('serialize', ['message', 'errors']);
            $this->response = $this->response->withStatus(422);

        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Usuário não encontrado para edição.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
    }

    /**
     * Delete method (DELETE /user-accounts/1.json)
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']); 
        
        try {
            $userAccount = $this->UserAccount->get($id);
            if ($this->components()->has('Authorization')) {
                $this->Authorization->authorize($userAccount, 'delete');
            }

            if ($this->UserAccount->delete($userAccount)) {
                // SUCESSO: Retorna status 204 No Content
                $this->response = $this->response->withStatus(204); 
                return $this->response;
            } 
            
            // FALHA NA EXCLUSÃO (Interna)
            $this->response = $this->response->withStatus(500); 
            $this->set(['message' => 'Não foi possível excluir o usuário devido a um erro interno.']);
            $this->viewBuilder()->setOption('serialize', ['message']);

        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->response = $this->response->withStatus(404);
            $this->set(['message' => 'Usuário não encontrado para exclusão.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
    }

    // -------------------------------------------------------------------------
    // AÇÕES DE AUTENTICAÇÃO
    // -------------------------------------------------------------------------

    /**
     * Login method (POST /user-accounts/login.json)
     */
    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post', 'options']); 
        
        $result = $this->Authentication->getResult();
        
        if ($result->isValid()) {
            // SUCESSO: Retorna status 200 OK
            
            // 🌟 CORREÇÃO FINAL AQUI: Usamos getOriginalData() antes de toArray() 🌟
            // O getIdentity() retorna um decorator, precisamos extrair a entidade original dele.
            $user = $this->Authentication->getIdentity()->getOriginalData()->toArray();
            
            // Remove o hash da senha do retorno JSON por segurança
            unset($user['password_hash']);

            $this->set(compact('user'));
            $this->viewBuilder()->setOption('serialize', ['user']);
            $this->response = $this->response->withStatus(200);
            return;
        } 
        
        // FALHA NA AUTENTICAÇÃO (Apenas se o método foi POST e falhou)
        if ($this->request->is('post') && !$result->isValid()) {
            $this->response = $this->response->withStatus(401); 
            $this->set(['message' => 'Usuário ou senha inválidos.']);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return;
        }
    }

    /**
     * Logout method (POST /user-accounts/logout.json)
     */
    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post', 'options']);
        
        $this->Authentication->logout();
        
        // SUCESSO: Retorna status 200 OK
        $this->response = $this->response->withStatus(200); 
        $this->set(['message' => 'Logout realizado com sucesso.']);
        $this->viewBuilder()->setOption('serialize', ['message']);
        return;
    }
}