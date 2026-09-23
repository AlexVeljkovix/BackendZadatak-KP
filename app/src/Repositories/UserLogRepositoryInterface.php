<?php

declare(strict_types=1);

namespace App\Repositories;

interface UserLogRepositoryInterface
{
    public function create(int $userId, string $action): int;
}