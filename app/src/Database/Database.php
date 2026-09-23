<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Query\CompiledQuery;
use mysqli;
use mysqli_stmt;
use RuntimeException;

class Database
{
    public function __construct(private mysqli $connection)
    {
    }

    public function connection(): mysqli
    {
        return $this->connection;
    }

    public function execute(CompiledQuery $query): mysqli_stmt
    {
        $statement= $this->connection()->prepare($query->sql);

        if($statement === false){
            throw new RuntimeException('Failed to prepare SQL statement.');
        }
        
        if (!$statement->execute($query->parameters)) {
            throw new RuntimeException('Failed to execute SQL statement.');
        }
        
        return $statement;
    }

    public function beginTransaction(): void
    {
        if(!$this->connection()->begin_transaction()){
            throw new RuntimeException('Unable to start transaction.');
        }
    }

    public function commit(): void
    {
        if(!$this->connection()->commit()){
            throw new RuntimeException('Unable to commit transaction.');
        }
    }

    public function rollback(): void
    {
        if(!$this->connection()->rollback()){
            throw new RuntimeException('Unable to rollback transaction.');
        }
    }
}