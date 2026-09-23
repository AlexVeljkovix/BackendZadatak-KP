<?php

declare(strict_types=1);

namespace App\Mail;

use Override;

class RegistrationMail implements Mail
{
    #[Override]
    public function subject(): string 
    {
        return "Dobro Dosli";
    }

    #[Override]
    public function message(): string
    {
        return "Uspesno ste se registrovali na nas sajt";
    }
}