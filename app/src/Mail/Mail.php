<?php

declare(strict_types=1);

namespace App\Mail;

interface Mail
{
    public function subject(): string;

    public function message(): string;
}