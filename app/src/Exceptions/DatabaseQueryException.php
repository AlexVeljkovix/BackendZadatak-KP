<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class DatabaseQueryException extends Exception
{
    protected $message = "Database query failed."; 
}