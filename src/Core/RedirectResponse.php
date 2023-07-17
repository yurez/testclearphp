<?php

namespace TestClearPhp\Core;

class RedirectResponse extends Response
{
    public function __construct(
        private string $redirectUrl,
        private int $statusCode = 302,
        private array $headers = []
    ) {
        $this->headers['Location'] = $this->redirectUrl;
        parent::__construct('', $this->statusCode, $this->headers);
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }
}
