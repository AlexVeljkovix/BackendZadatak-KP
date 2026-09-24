<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use App\Validation\Rules\Rule;
use App\Validation\ValidationError;
use Override;

class Required implements Rule
{
    public function __construct(private string $field)
    {
    }
    #[Override]
    public function validate(array $data): ?ValidationError
    {
        $value=$data[$this->field] ?? null;
        
        if(!is_string($value) || trim($value)===''){
            return new ValidationError($this->field, 'required');
        }
        return null;
    }
}