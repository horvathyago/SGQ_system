<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

// --- Imports para CORS e PSR ---
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface; 

// --- Imports de Autenticação (Authentication) ---
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;

// --- Imports de Autorização (Authorization) ---
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware; 
use Authorization\Policy\OrmResolver;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        $this->addPlugin('Authentication');
        $this->addPlugin('Authorization');
        FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
    }

    /**
     * Setup the middleware queue your application will use.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // 1. Tratamento de Erros
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))

            // 🌟 2. MIDDLEWARE CORS (CURTO-CIRCUITO) 🌟
            ->add(function (ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
                
                // Definimos os headers permitidos
                $headers = [
                    'Access-Control-Allow-Origin' => 'http://localhost:5173',
                    'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
                    'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With, Authorization, Accept',
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Max-Age' => '3600',
                ];

                // SE FOR UMA REQUISIÇÃO 'OPTIONS' (PREFLIGHT):
                // Respondemos IMEDIATAMENTE aqui, sem passar para o resto do sistema.
                // Isso evita erros de autenticação ou roteamento no preflight.
                if ($request->getMethod() === 'OPTIONS') {
                    $response = new \Cake\Http\Response();
                    foreach ($headers as $key => $value) {
                        $response = $response->withHeader($key, $value);
                    }
                    return $response->withStatus(200);
                }

                // SE FOR UMA REQUISIÇÃO NORMAL (GET, POST...):
                // Deixa o CakePHP processar...
                $response = $handler->handle($request);

                // ... e adiciona os headers na volta.
                foreach ($headers as $key => $value) {
                    $response = $response->withHeader($key, $value);
                }

                return $response;
            })

            // 3. Assets Estáticos
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // 4. Roteamento
            ->add(new RoutingMiddleware($this))

            // 5. Body Parser
            ->add(new BodyParserMiddleware())

            // 6. Autenticação
            ->add(new AuthenticationMiddleware($this))

            // 7. Autorização
            ->add(new AuthorizationMiddleware($this, [ 
                'requireAuthorizationCheck' => false,
            ]));

        return $middlewareQueue;
    }
    
    /**
     * Configuração do Serviço de Autenticação (Login)
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService([
            'unauthenticatedRedirect' => null, 
            'queryParam' => 'redirect',
        ]);

        $fieldsForInput = [
            'username' => 'email',
            'password' => 'password', 
        ];

        $fieldsForDatabase = [
            'username' => 'email',
            'password' => 'password_hash',
        ];

        $service->loadIdentifier('Authentication.Password', [
            'fields' => $fieldsForDatabase, 
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => 'UserAccount', // CamelCase correto
            ],
        ]);

        $service->loadAuthenticator('Authentication.Session');

        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fieldsForInput,
        ]);
        
        $service->loadAuthenticator('Authentication.Token', [
            'header' => 'Authorization',
            'tokenPrefix' => 'Bearer',
        ]);

        return $service;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();
        return new AuthorizationService($resolver);
    }
    
    public function services(ContainerInterface $container): void
    {
    }
}