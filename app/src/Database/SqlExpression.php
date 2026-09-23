<?php

declare(strict_types=1);

namespace App\Database;

class SqlExpression
{
    public function __construct(public string $expression)
    {
    }

    public static function raw(string $expression): static{
        return new static($expression);
    }

    public function toSql():string{
        return $this->expression;
    }
}