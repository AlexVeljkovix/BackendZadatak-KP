<?php

declare(strict_types=1);

namespace App\Http;

use Override;

class JsonResponse extends Response
{
    public function __construct(mixed $data, int $statusCode = 200)
    {
        parent::__construct(json_encode($data, JSON_THROW_ON_ERROR), $statusCode, 'application/json; charset=UTF-8');
    }
}