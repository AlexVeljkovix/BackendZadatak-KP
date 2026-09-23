<?php

declare(strict_types=1);

namespace App\Validation;

interface Rule
{
    public function validate(array $data): ?ValidationError;
}