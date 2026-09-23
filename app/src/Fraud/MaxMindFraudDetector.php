<?php

declare(strict_types=1);

namespace App\Fraud;

use Override;

class MaxMindFraudDetector implements FraudDetectorInterface
{
    #[Override]
    public function isFraudulent(string $email, string $ip): bool
    {
        return false;
    }
}