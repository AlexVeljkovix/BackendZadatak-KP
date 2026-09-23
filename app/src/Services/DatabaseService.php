<?php

declare(strict_types=1);

namespace App\Services;

use App\Database\Database;

class DatabaseService
{
    public function __construct(private Database $database)
    {
    }

    public function beginTransaction(): void
    {
        $this->database->beginTransaction();
    }

    public function commit(): void
    {
        $this->database->commit();
    }

    public function rollback(): void
    {
        $this->database->rollback();
    }
}