<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\Event\EventInterface; // <<< ADICIONE ESTE IMPORT

class FrontendController extends AppController
{
    // <<< ADICIONE ESTE MÉTODO
    public function initialize(): void
    {
        parent::initialize();
        // Carrega o componente para poder usar allowUnauthenticated
        $this->loadComponent('Authentication.Authentication');
    }

    // <<< ADICIONE ESTE MÉTODO
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // O ponto de entrada da SPA (index.html) DEVE ser sempre não autenticado.
        $this->Authentication->allowUnauthenticated(['index']);
    }

    public function index(): Response
    {
        $file = WWW_ROOT . 'index.html';

        return new Response([
            'body' => file_get_contents($file),
            'type' => 'text/html'
        ]);
    }
}