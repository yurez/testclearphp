<?php

namespace TestClearPhp\Exception;

class ValidationException extends \InvalidArgumentException
{
    public function __construct(protected array $errors)
    {
        parent::__construct('Validation Errors');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
