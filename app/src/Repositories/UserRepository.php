<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\Database;
use App\Database\Query\InsertQuery;
use App\Database\Query\SelectQuery;
use App\Database\Query\UpdateQuery;
use App\Database\SqlExpression;
use Override;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private Database $database)
    {
    }

    #[Override]
    public function emailExists(string $email): bool
    {
        $selectBuilder= new SelectQuery();

        $compiled= $selectBuilder->select(['id'])
                                    ->from('user')
                                    ->where('email', '=', $email)
                                    ->build();

        $statement= $this->database->execute($compiled);

        $result= $statement->get_result();

        return $result->num_rows > 0;
        
    }

    #[Override]
    public function create(string $email, string $password): int
    {

        $insertBuilder= new InsertQuery();
        $compiled= $insertBuilder->into('user')
                        ->values(['email'=>$email, 'password'=>$password])
                        ->build();

        $statement = $this->database->execute($compiled);

        return $statement->insert_id;
    }
}