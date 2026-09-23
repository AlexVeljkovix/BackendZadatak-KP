<?php

declare(strict_types=1);

namespace App\Mail;

use Override;
use RuntimeException;

class Mailer implements MailerInterface
{
    public function __construct()
    {
    }

    #[Override]
    public function send(string $to, Mail $mail): void
    {
        $sent= mail($to, $mail->subject(), $mail->message());

        if(!$sent){
            throw new RuntimeException('Failed to send email.');
        }
    }


}