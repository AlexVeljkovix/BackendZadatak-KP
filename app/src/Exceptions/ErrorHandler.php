<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\HtmlResponse;
use App\Http\JsonResponse;
use App\Http\Response;
use Throwable;

class ErrorHandler
{
    public function handle(Throwable $exception): Response
    {
        if ($exception instanceof InvalidRouteException) {
            return new HtmlResponse(
                'Page not found.',
                404
            );
        }

        return new JsonResponse(
            ['success'=>false, 'code'=>'server_error'],
            500
        );
    }
}