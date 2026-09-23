<?php

declare(strict_types=1);

namespace App\Database\Query;

class CompiledQuery
{
    public function __construct(public string $sql, 
                                public array $parameters)
    {
    }
}