<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;

class PagesController extends AppController
{
    /**
     * Carrega o React no lugar dos templates do Cake
     *
     * @return \Cake\Http\Response
     */
    public function display(): Response
    {
        $indexPath = WWW_ROOT . 'index.html';

        if (!file_exists($indexPath)) {
            throw new NotFoundException(
                'O arquivo index.html do React não foi encontrado em webroot/. 
                Rode "npm run build" dentro de webroot/frontend e mova o dist para webroot.'
            );
        }

        // Desabilita layout do Cake
        $this->viewBuilder()->disableAutoLayout();
        
        // Define tipo HTML
        $this->response = $this->response->withType('html');

        // Retorna o index.html do React
        return $this->response->withStringBody(file_get_contents($indexPath));
    }
}
