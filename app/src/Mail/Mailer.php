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
        $headers = implode("\r\n", [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
        ]);

        $sent= mail($to, $mail->subject(), $mail->message(), $headers);

        if(!$sent){
            throw new RuntimeException('Failed to send email.');
        }
    }


}