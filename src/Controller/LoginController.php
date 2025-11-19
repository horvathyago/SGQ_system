<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class LoginController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'logout']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // Se já estiver autenticado, redireciona
        if ($result && $result->isValid()) {
            $redirect = $this->Authentication->getLoginRedirect() ?? [
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ];
            return $this->redirect($redirect);
        }

        // Caso o POST falhe
        if ($this->request->is('post') && (!$result || !$result->isValid())) {
            $this->Flash->error(__('Usuário ou senha incorretos.'));
        }

        $this->render('login'); // ✅ nome da view correto
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $this->Authentication->logout();
        }

        $this->Flash->success(__('Você saiu do sistema.'));
        return $this->redirect(['controller' => 'Login', 'action' => 'login']);
    }
}