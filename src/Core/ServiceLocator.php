<?php

namespace TestClearPhp\Core;

class ServiceLocator
{
    private array $services = [];

    public function addService(string $name, object|string $service): void
    {
        $this->services[$name] = $service;
    }

    public function getService(string $name): ?object
    {
        return $this->services[$name] ?? null;
    }
}
