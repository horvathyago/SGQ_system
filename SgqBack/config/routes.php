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

        // 2. ROTAS DE AUTENTICAÇÃO
        $builder->connect('/user-account/login', 
            ['controller' => 'UserAccount', 'action' => 'login'])
            ->setMethods(['POST', 'OPTIONS']);

        $builder->connect('/user-account/logout', 
            ['controller' => 'UserAccount', 'action' => 'logout'])
            ->setMethods(['POST', 'OPTIONS']);
            
        // 3. ROTEAMENTO DO USERACCOUNT
        $builder->resources('UserAccount', [
            'only' => ['index', 'view', 'add', 'edit', 'delete', 'status'],
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
        ]);
        
        // =======================================================================
        // 🌟 4. ROTAS RESTful ESSENCIAIS PARA O PROCESSO DE INSPEÇÃO (ADICIONADAS) 🌟
        // =======================================================================

        // ROTEAMENTO PARA ITEM MASTER (O produto/peça a ser inspecionado)
        // Ex: /item-master.json, /item-master/1.json
        $builder->resources('ItemMaster', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
        ]);

        // ROTEAMENTO PARA INSPECTION (Criação/Ciclo de Vida)
        $builder->resources('Inspection', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
        ]);
        
        // ROTEAMENTO PARA CHECKLIST TEMPLATE (Estrutura do Checklist)
        $builder->resources('ChecklistTemplate', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
        ]);

        // ROTEAMENTO PARA INSPECTION ITEM (Registro de Resultados)
        $builder->resources('InspectionItem', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'],
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
        ]);
        
        // ROTEAMENTO PARA TEMPLATE ITEM (Passos Individuais do Checklist)
        $builder->resources('TemplateItem', [
            'only' => ['index', 'view', 'add', 'edit', 'delete'], 
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
        ]);


        // --- Rotas Padrão do CakePHP ---

        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/pages/*', 'Pages::display');
        $builder->fallbacks();
    });
};