<?php

namespace TestClearPhp\Controller;

use TestClearPhp\Core\RedirectResponse;
use TestClearPhp\Core\Response;
use TestClearPhp\Core\ServiceLocator;

abstract class BaseController
{
    public function __construct(
        protected ServiceLocator $serviceLocator
    ) {}

    protected function render(string $template, array $vars = []): Response
    {
        return new Response(
            $this->renderTemplate($template, $vars)
        );
    }

    private function renderTemplate(string $template, array $vars): string
    {
        extract($vars);

        ob_start();
        include __DIR__ . '/../../template/' . $template;

        return ob_get_clean();
    }

    protected function redirectToRoute(string $uri, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($uri, $status);
    }
}
