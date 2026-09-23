<?php

declare(strict_types=1);

namespace App\Database\Query;

use App\Database\SqlExpression;
use LogicException;
use Override;

class UpdateQuery implements Query
{
    private string $table;

    private array $setParams=[];

    private array $conditions=[];

    public function update(string $table): static
    {
        $this->table=$table;
        return $this;
    }

    public function set(array $setParams): static
    {
        $this->setParams=$setParams;
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): static
    {
        $this->conditions[]=[
            'column'=> $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    #[Override]
    public function build(): CompiledQuery
    {
        if (!isset($this->table) || $this->setParams === [] || $this->conditions === []) {
            throw new LogicException('Query builder parameters missing.');
        }

        $sql='';
        $parameters=[];
        $set=[];
        $where=[];
        foreach($this->setParams as $setParamColumn =>$setParamValue){

            if($setParamValue instanceof SqlExpression){
                $expression= $setParamValue->toSql();
                $set[]= "{$setParamColumn} = " . $expression;
                continue;
            }


            $set[] = "{$setParamColumn} = ?";
            $parameters[] = $setParamValue;
        }

        foreach($this->conditions as $condition){
            $column = $condition['column'];
            $operator = $condition['operator'];
            $value = $condition['value'];

            if($value instanceof SqlExpression){
                $expression= $value->toSql();
                $where[]= "{$column} {$operator} " . $expression;
                continue;
            }


            $where[]= "{$column} {$operator} ?";
            $parameters[] = $value;
        }


        $set= implode(', ', $set);
        $where= implode(' AND ', $where);

        $sql="UPDATE {$this->table} SET {$set} WHERE {$where}";
        return new CompiledQuery($sql, $parameters);
    }
}