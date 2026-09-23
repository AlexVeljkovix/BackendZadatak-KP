<?php

declare(strict_types=1);

namespace App\Database\Query;

use App\Database\SqlExpression;
use LogicException;
use Override;

class SelectQuery implements Query
{
    private string $table;
    private array $columns=[];
    private array $conditions=[];

    public function from(string $table): static
    {
        $this->table=$table;
        return $this;
    }

    public function select(array $columns=['*']): static
    {
        $this->columns=$columns;
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): static
    {
        $this->conditions[]= ['column' => $column,
                            'operator' => $operator,
                            'value'=>$value];
        return $this;
    }

    #[Override]
    public function build(): CompiledQuery
    {
        if (!isset($this->table) || $this->columns === []) {
            throw new LogicException('Query builder parameters missing.');
        }

        $columns=implode(', ', $this->columns);
        $sql="SELECT {$columns} FROM {$this->table} ";
        $parameters=[];


        if($this->conditions !== []){
            $where=[];

            foreach($this->conditions as $condition){
                $column=$condition['column'];
                $operator=$condition['operator'];
                $value= $condition['value'];

                $whereExpression= "{$column} {$operator} ";

                if($value instanceof SqlExpression){
                    $expression=$value->toSql();
                    $whereExpression.="{$expression}";
                    $where[] = $whereExpression;    
                    continue;
                }

                $whereExpression.='?';
                $where[] = $whereExpression;    
                $parameters[]=$value;
            }

            $where= implode('AND ', $where);
            $sql.="WHERE {$where}";
        }

        return new CompiledQuery($sql, $parameters);

    }
}