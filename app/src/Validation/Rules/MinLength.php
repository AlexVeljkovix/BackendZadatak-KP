<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use App\Validation\Rule;
use App\Validation\ValidationError;
use Override;

class MinLength implements Rule
{
    public function __construct(private string $field, private int $length)
    {
    }

    #[Override]
    public function validate(array $data): ?ValidationError
    {
        $value=$data[$this->field] ?? null;

        if(! is_string($value) || mb_strlen($value) < $this->length){
            return new ValidationError($this->field, 'min_length');
        }

        return null;
    }
}