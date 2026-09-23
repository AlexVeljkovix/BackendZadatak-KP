<?php

declare(strict_types=1);

namespace App\Validation;

class ValidationError
{
    public function __construct(public string $field, public string $code)
    {
    }
}