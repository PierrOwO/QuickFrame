<?php
namespace Support\Vault\Validation\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected array $errors;

    public function __construct(array $errors = [], $message = "Validation failed", $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}