<?php

declare(strict_types=1);

use App\Container;
use App\Database\Database;
use App\Exceptions\DatabaseConnectionException;
use App\Fraud\FraudDetectorInterface;
use App\Fraud\MaxMindFraudDetector;
use App\Mail\Mailer;
use App\Mail\MailerInterface;
use App\Repositories\UserLogRepository;
use App\Repositories\UserLogRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Session\SessionInterface;
use App\Session\SessionService;

$container= new Container();

$container->bind(Container::class, fn()=>$container);

$container->bind(UserRepositoryInterface::class, UserRepository::class);

$container->bind(FraudDetectorInterface::class, MaxMindFraudDetector::class);

$container->bind(Database::class, function(){
    $host = getenv('DB_HOST');
    $username = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');
    $database= getenv('MYSQL_DATABASE');

    if($host === false || $username === false || $password === false || $database === false){
        throw new RuntimeException("Database configuration is missing");
    }

    $connection= new mysqli(
        $host,
        $username,
        $password,
        $database
    );

    if($connection->connect_errno){
        throw new DatabaseConnectionException();
    }

    $connection->set_charset('utf8mb4');

    return new Database($connection);
});

$container->bind(SessionInterface::class, SessionService::class);

$container->bind(MailerInterface::class, Mailer::class);

$container->bind(UserLogRepositoryInterface::class, UserLogRepository::class);

return $container;