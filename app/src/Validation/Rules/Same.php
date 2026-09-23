<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use App\Validation\Rule;
use App\Validation\ValidationError;
use Override;

class Same implements Rule
{
    public function __construct(private string $field, private string $otherField)
    {
    }
    #[Override]
    public function validate(array $data): ?ValidationError
    {
        $value= $data[$this->field] ?? null;
        $other= $data[$this->otherField] ?? null;


        if(!is_string($value) || !is_string($other) ||  
            $value !== $other){
            return new ValidationError($this->field, 'password_mismatch');
        }
        return null;
    }
}