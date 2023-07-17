<?php

namespace TestClearPhp\Core;

use TestClearPhp\Model\User;

class Router
{
    private array $routes = [];

    public function addRoute(string $path, callable $controller): void
    {
        $this->routes[$path] = $controller;
    }

    public function addRoutes(array $config): void
    {
        foreach ($config as $routePath => $routeController)
        {
            $this->addRoute($routePath, $routeController);
        }
    }

    public function handleRequest(Request $request, ?User $user): Response
    {
        $path = $request->getRequestPath();

        if (array_key_exists($path, $this->routes)) {
            $controller = $this->routes[$path];

            return $controller($request, $user);
        } else {
            // If the route doesn't exist, show a 404 page.
            return new Response('Page not found', 404);
        }
    }
}
