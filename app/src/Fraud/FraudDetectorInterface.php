<?php

declare(strict_types=1);

namespace App\Fraud;

interface FraudDetectorInterface
{
    public function isFraudulent(string $email, string $ip): bool;
}