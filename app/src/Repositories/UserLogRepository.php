<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\Database;
use App\Database\Query\InsertQuery;
use App\Database\SqlExpression;
use Override;

class UserLogRepository implements UserLogRepositoryInterface
{
    public function __construct(private Database $database)
    {
    }
    #[Override]
    public function create(int $userId, string $action): int
    {
        $insertBuilder= new InsertQuery();

        $compiled =$insertBuilder->into('user_log')
                                    ->values(['user_id'=>$userId,
                                            'action' => $action,
                                            'log_time' => SqlExpression::raw('NOW()')])
                                    ->build();
        $statement = $this->database->execute($compiled);

        return $statement->insert_id;
    }
}