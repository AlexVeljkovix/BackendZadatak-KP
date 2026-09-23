<?php

declare(strict_types=1);

namespace App\Session;

use Override;

class SessionService implements SessionInterface
{
    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    #[Override]
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key]= $value;
    }

    #[Override]
    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }
}