<?php

declare(strict_types=1);

namespace App\Mail;

use Override;

class RegistrationMail implements Mail
{
    #[Override]
    public function subject(): string 
    {
        return "Dobro Došli";
    }

    #[Override]
    public function message(): string
    {
        return "Uspešno ste se registrovali na naš sajt!";
    }
}