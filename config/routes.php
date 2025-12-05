<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

return function (RouteBuilder $routes): void {

    $routes->setRouteClass(DashedRoute::class);



    // ROTA PRINCIPAL SERVE O REACT
    $routes->connect('/', ['controller' => 'Frontend', 'action' => 'index']);

    // QUALQUER OUTRA ROTA TAMBÉM SERVE O REACT
    $routes->connect(
        '/{path}',
        ['controller' => 'Frontend', 'action' => 'index'],
        [
            'pass' => ['path'],
            // O regex '[^.]+' garante que esta rota só será acionada se o caminho não tiver um ponto (que indicaria um arquivo)
            'path' => '[^.]+',
        ]
    );
    // Se quiser APIs ou controllers normais, coloque aqui:
    $routes->scope('/api', function (RouteBuilder $builder) {
        // exemplo:
        // $builder->connect('/users', ['controller' => 'Users', 'action' => 'index']);
    });
};
