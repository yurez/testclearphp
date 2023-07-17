<?php

namespace TestClearPhp\Core;

use Dotenv\Dotenv;
use TestClearPhp\Exception\AuthorizationException;
use TestClearPhp\Security\SecurityFirewall;
use TestClearPhp\Security\SecurityService;

final class Kernel
{
    private Router $router;

    private SecurityFirewall $securityFirewall;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->router = new Router();

        $serviceLocator = $this->buildServiceLocator();

        $routesConfig = require_once  __DIR__ . '/../../config/routes.php';

        $this->router->addRoutes($routesConfig);

        /** @var SecurityService $securityService */
        $securityService = $serviceLocator->getService(SecurityService::class);

        $this->securityFirewall = new SecurityFirewall(
            $securityService
        );

        $securityConfig = require_once  __DIR__ . '/../../config/security.php';

        $this->securityFirewall->addFirewallsConfig($securityConfig);
    }

    public function handleRequest(Request $request): void
    {
        session_start();
        try {
            $user = $this->securityFirewall->handleRequest($request);
            $response = $this->router->handleRequest($request, $user);
        } catch (AuthorizationException $e) {
            $response = new RedirectResponse('/?errorMessage=User+should+be+logged+in', 401);
        }

        $response->send();
    }

    protected function buildServiceLocator(): ServiceLocator
    {
        $serviceLocator = new ServiceLocator();

        return require_once __DIR__ . '/../../config/services.php';
    }
}
