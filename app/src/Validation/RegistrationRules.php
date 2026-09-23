<?php

declare(strict_types=1);

namespace App\Validation;

use App\Fraud\FraudDetectorInterface;
use App\Repositories\UserRepositoryInterface;
use App\Validation\Rules\Email;
use App\Validation\Rules\FraudCheck;
use App\Validation\Rules\MinLength;
use App\Validation\Rules\Required;
use App\Validation\Rules\Same;
use App\Validation\Rules\UniqueEmail;

class RegistrationRules
{
    public function __construct(private UserRepositoryInterface $userRepo, private FraudDetectorInterface $fraudDetector)
    {
    }

    public function rules(): array
    {
        return [
            new Required('email'),
            new Email('email'),
            new UniqueEmail('email', $this->userRepo),

            new Required('password'),
            new MinLength('password', 8),

            new Required('password2'),
            new MinLength('password2', 8),
            new Same('password2', 'password'),

            new FraudCheck('email', 'ip', $this->fraudDetector)
        ];
    }
}