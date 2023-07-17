<?php

namespace TestClearPhp\Controller;

use TestClearPhp\Core\Request;
use TestClearPhp\Core\Response;
use TestClearPhp\Exception\AuthenticationException;
use TestClearPhp\Security\SecurityService;

class SecurityController extends BaseController
{
    public function login(Request $request): Response
    {
        /** @var SecurityService $securityService */
        $securityService = $this->serviceLocator->getService(SecurityService::class);

        if ($securityService->isLoggedIn()) {
            return $this->redirectToRoute('/dashboard');
        }

        if ($request->getMethod() === 'POST') {
            try {
                $securityService->authenticate($request->get('email'), $request->get('password'));
            } catch (AuthenticationException $e) {
                return $this->render('login.html', ['errorMessage' => 'Invalid email or password.']);
            }

            return $this->redirectToRoute('/dashboard');
        }

        return $this->render('login.html');
    }

    public function logout(Request $request): Response
    {
        /** @var SecurityService $securityService */
        $securityService = $this->serviceLocator->getService(SecurityService::class);

        if ($securityService->isLoggedIn()) {
            $securityService->removeUserFromSession();
        }

        return $this->redirectToRoute('/');
    }
}
