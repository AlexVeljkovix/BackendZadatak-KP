<?php

declare(strict_types=1);

namespace App\Services;

use App\Database\Database;
use App\Mail\MailerInterface;
use App\Mail\RegistrationMail;
use App\Repositories\UserLogRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Session\SessionInterface;
use Exception;
use RuntimeException;
use Throwable;

class RegistrationService
{
    public function __construct(private UserRepositoryInterface $userRepo,
                                private SessionInterface $sessionService,
                                private MailerInterface $mailer,
                                private UserLogRepositoryInterface $userLogRepo,
                                private Database $database)
    {
    }

    public function register(string $email, string $password): int
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if($passwordHash === false){
            throw new RuntimeException('Password hashing failed.');
        }

        try{
            $this->database->beginTransaction();

            $userId = $this->userRepo->create($email, $passwordHash);

            $this->userLogRepo->create($userId, 'register');

            $this->database->commit();

        }catch(Throwable $exception){

            $this->database->rollback();

            throw $exception;
        }

        $this->sessionService->set('userId', $userId);

        $this->mailer->send($email, new RegistrationMail());

        return $userId;
    } 
}