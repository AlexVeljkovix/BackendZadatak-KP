<?php

declare(strict_types=1);

namespace App\Validation\Rules;

use App\Fraud\FraudDetectorInterface;
use App\Validation\Rule;
use App\Validation\ValidationError;
use Override;

class FraudCheck implements Rule
{
    public function __construct(private string $emailField, private string $ipField, private FraudDetectorInterface $fraudDetector)
    {
    }
    #[Override]
    public function validate(array $data): ?ValidationError
    {
        $email=$data[$this->emailField] ?? null;
        $ip= $data[$this->ipField] ?? null;

        if(! is_string($email) || !is_string($ip)){
            return null;
        }

        if($this->fraudDetector->isFraudulent($email, $ip)){
            return new ValidationError($this->emailField, 'fraud_detected');
        }

        return null;
    }
}