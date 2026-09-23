<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\HtmlResponse;
use Throwable;

class ErrorHandler
{
    public function handle(Throwable $exception): HtmlResponse
    {
        if ($exception instanceof InvalidRouteException) {
            return new HtmlResponse(
                'Page not found.',
                404
            );
        }

        return new HtmlResponse(
            'Internal server error.',
            500
        );
    }
}