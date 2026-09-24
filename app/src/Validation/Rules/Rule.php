<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use App\Validation\ValidationError;

interface Rule
{
    public function validate(array $data): ?ValidationError;
}