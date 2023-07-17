<?php

namespace TestClearPhp\Controller;

use TestClearPhp\Core\Request;
use TestClearPhp\Core\Response;
use TestClearPhp\Exception\ValidationException;
use TestClearPhp\Model\User;
use TestClearPhp\Service\RegistrationFormProcessor;

class MainController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->render('index.html', ['errorMessage' => $request->get('errorMessage')]);
    }

    public function dashboard(Request $request, User $user): Response
    {
        return $this->render('dashboard.html' , ['username' => $user->getFirstName()]);
    }

    public function register(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            /** @var RegistrationFormProcessor $formProcessor */
            $formProcessor = $this->serviceLocator->getService(RegistrationFormProcessor::class);

            try {
                $formProcessor->process($request);
            } catch (ValidationException $e) {
                return $this->render('register.html', ['errors' => $e->getErrors()]);
            }

            return $this->render('register_success.html');
        }

        return $this->render('register.html');
    }
}
