<?php

declare(strict_types=1);

namespace App\Database\Query;

use App\Database\SqlExpression;
use LogicException;
use Override;

class InsertQuery implements Query
{
    private string $table;
    private array $values= [];

    public function into(string $table): static{
        $this->table=$table;
        return $this;
    }

    public function values(array $values): static{
        $this->values=$values;
        return $this;
    }

    #[Override]
    public function build(): CompiledQuery
    {
        
        if (!isset($this->table) || $this->values===[]) {
            throw new LogicException('Query builder parameters missing.');
        }
        
        $columns= array_keys($this->values);
        $placeholders=[];
        $parameters=[];


        foreach($this->values as $value){
            if($value instanceof SqlExpression){
                $placeholders[] = $value->toSql();
                continue;
            }

            $placeholders[]= '?';
            $parameters[]= $value;

        }

        $columns= implode(', ', $columns);
        $placeholders= implode(', ', $placeholders);
        $sql= "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        return new CompiledQuery($sql, $parameters);
    }
}