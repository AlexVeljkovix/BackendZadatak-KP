<?php

declare(strict_types=1);

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function emailExists(string $email): bool;

    public function create(string $email, string $password) :int;
}