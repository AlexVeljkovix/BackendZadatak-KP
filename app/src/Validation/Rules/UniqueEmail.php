<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use App\Repositories\UserRepositoryInterface;
use App\Validation\Rule;
use App\Validation\ValidationError;
use Override;

class UniqueEmail implements Rule
{
    public function __construct(private string $field, private UserRepositoryInterface $userRepo)
    {
    }

    #[Override]
    public function validate(array $data): ?ValidationError
    {
        $value=$data[$this->field] ?? null;

        if(!is_string($value)){
            return null;
        }

        if($this->userRepo->emailExists($value)){
            return new ValidationError($this->field, 'email_exists');
        }
        return null;
    }
}