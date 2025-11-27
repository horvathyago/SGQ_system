<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

// --- Imports de Autenticação (Authentication) ---
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

// --- Imports de Autorização (Authorization) ---
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     */
    public function bootstrap(): void
    {
        parent::bootstrap();

        // Carrega os plugins essenciais
        $this->addPlugin('Authentication');
        $this->addPlugin('Authorization');

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
    }

    /**
     * Setup the middleware queue your application will use.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // 1. Tratamento de Erros
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))

            // 2. Assets Estáticos
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // 3. Roteamento (Define qual Controller/Action será chamado)
            ->add(new RoutingMiddleware($this))

            // 4. Body Parser (Converte JSON/XML/Form Data do request em array)
            // Essencial vir ANTES da Autenticação e CSRF para ler os dados enviados.
            ->add(new BodyParserMiddleware())

            // 5. Proteção CSRF
            // Recomendado vir ANTES da Autenticação para evitar ataques de login falsos.
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]))

            // 6. Autenticação (Identifica QUEM é o usuário)
            ->add(new AuthenticationMiddleware($this))

            // 7. Autorização (Verifica O QUE o usuário identificado pode fazer)
            // Deve vir estritamente APÓS a Autenticação.
            ->add(new AuthorizationMiddleware($this, [
                // Define como false para não lançar exceção se você esquecer de checar a permissão.
                // Mantém o login fluindo enquanto as policies não estão 100% criadas.
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
            'unauthenticatedRedirect' => '/useraccount/login', // Para onde vai se não estiver logado
            'queryParam' => 'redirect',
        ]);

        // Restaura a configuração exata dos campos do seu código original
        $fields = [
            'username' => 'email',
            'password' => 'password_hash', // Restaurado: Seu banco/form usa 'password_hash'
        ];

        // 1. Identificador (Busca o usuário no banco de dados)
        $service->loadIdentifier('Authentication.Password', [
            'fields' => $fields,
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => 'Useraccount', // Mantido conforme seu código original
            ],
        ]);

        // 2. Autenticador de Sessão (Mantém o usuário logado entre páginas)
        $service->loadAuthenticator('Authentication.Session');

        // 3. Autenticador de Formulário (Processa o POST do login)
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => '/useraccount/login', // URL que recebe o POST de login
        ]);

        return $service;
    }

    /**
     * Configuração do Serviço de Autorização (Permissões)
     */
    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        // O OrmResolver mapeia automaticamente a Entidade para a Policy.
        // Ex: A entidade "App\Model\Entity\Useraccount" buscará a Policy "App\Policy\UseraccountPolicy"
        $resolver = new OrmResolver();

        return new AuthorizationService($resolver);
    }
}