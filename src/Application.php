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

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Error handler / asset / routing
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this));

        // --- Authentication deve vir ANTES do CSRF e BodyParser ---
        $middlewareQueue->add(new AuthenticationMiddleware($this));

        // Corpo das requisições (JSON/form-data)
        $middlewareQueue->add(new BodyParserMiddleware());

        // Proteção CSRF (depois de Authentication)
        $middlewareQueue->add(new CsrfProtectionMiddleware([
            'httponly' => true,
        ]));

        return $middlewareQueue;
    }

    /**
     * Configuração do AuthenticationService
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService([
            'unauthenticatedRedirect' => '/login/login',
            'queryParam' => 'redirect',
        ]);

        // IDENTIFICADOR (verifica usuário no banco)
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',
                // <-- usar password_hash pois esse é o campo do seu banco
                'password' => 'password_hash',
            ],
            'resolver' => [
                'className' => 'Authentication.Orm',
                'model' => 'UserAccount',   // nome do Model (sem 'Table')
            ],
            'passwordHasher' => DefaultPasswordHasher::class,
        ]);

        // AUTENTICADOR (pega dados do formulário)
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',  // campo enviado no form
            ],
            'loginUrl' => '/login/login',
        ]);

        return $service;
    }

    public function services(ContainerInterface $container): void
    {
        // Mantido vazio
    }
}
