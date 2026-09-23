<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidRouteException extends Exception
{
    protected $message="Route does not exist";
}