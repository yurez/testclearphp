<?php

namespace TestClearPhp\Security;

use TestClearPhp\Core\Request;
use TestClearPhp\Exception\AuthorizationException;
use TestClearPhp\Model\User;

class SecurityFirewall
{
    protected array $firewalls = [];

    public function __construct(
        protected SecurityService $securityService
    ) {}

    public function addFirewallsConfig(array $firewallsConfig): void
    {
        $this->firewalls = $firewallsConfig;
    }

    /**
     * @throws AuthorizationException
     */
    public function handleRequest(Request $request): ?User
    {
        $path = $request->getRequestPath();

        if (!isset($this->firewalls[$path])) {
            return null;
        }

        $config = $this->firewalls[$path];

        $checkAuth = $config['auth'] ?? false;

        if ($checkAuth
            && $this->securityService->isLoggedIn()
            && $user = $this->securityService->getUserFromSession()
        ) {

            return $user;
        } elseif ($checkAuth) {
            throw new AuthorizationException('User should be logged in');
        }

        return null;
    }
}
