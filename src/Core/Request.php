<?php

namespace TestClearPhp\Core;

final class Request
{
    public function __construct(
        public array $post,
        public array $get,
        protected array $server
    ) {}

    public static function createFromGlobals(): self
    {
        return new Request($_POST, $_GET, $_SERVER);
    }

    public function get(string $name, mixed $default = null): mixed
    {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        } elseif (isset($this->get[$name])) {
            return $this->get[$name];
        }

        return $default;
    }

    public function getRequestPath(): string
    {
        return (string) parse_url($this->getRequestUri(), PHP_URL_PATH);
    }

    public function getRequestUri(): string
    {
        return $this->server['REQUEST_URI'] ?? '';
    }

    public function getMethod(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }
}
