<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use App\Validation\Rule;
use App\Validation\ValidationError;
use Override;

class Email implements Rule
{
    public function __construct(private string $field)
    {
    }
    #[Override]
    public function validate(array $data): ?ValidationError 
    {
        $value=$data[$this->field] ?? null;

        if(!is_string($value) || filter_var($value, FILTER_VALIDATE_EMAIL) === false){
            return new ValidationError($this->field, "email_format");
        }

        return null;
    }

}