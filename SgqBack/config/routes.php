<?php
/**
 * Routes configuration.
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        
        // 1. HABILITA EXTENSÃO .json para URLs
        $builder->setExtensions(['json']);

        // 2. CONEXÃO EXPLÍCITA DAS AÇÕES CUSTOMIZADAS (login/logout)
        // Definimos estas rotas PRIMEIRO, pois são exceções aos padrões CRUD.

        // Rota para POST de login (URL: /user-account/login.json)
        // ❗ CORREÇÃO: Usando a URL singular /user-account/login
        $builder->connect('/user-account/login', 
            ['controller' => 'UserAccount', 'action' => 'login'])
            ->setMethods(['POST', 'OPTIONS']);

        // Rota para logout (URL: /user-account/logout.json)
        // ❗ CORREÇÃO: Usando a URL singular /user-account/logout
        $builder->connect('/user-account/logout', 
            ['controller' => 'UserAccount', 'action' => 'logout'])
            ->setMethods(['POST', 'OPTIONS']);
            
        // 3. ROTEAMENTO DO USERACCOUNT COMO API RESTFUL
        // Ele criará URLs no formato singular: /user-account.json, /user-account/1.json
        $builder->resources('UserAccount', [
            // O nome singular mapeia corretamente para UserAccountController
            'only' => ['index', 'view', 'add', 'edit', 'delete', 'status'],
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
        ]);
        
        // --- Rotas Padrão do CakePHP ---

        /*
         * Rota padrão para a página inicial
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * ...e connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');
        

        /*
         * Connect catchall routes for all controllers.
         */
        $builder->fallbacks();
    });
};