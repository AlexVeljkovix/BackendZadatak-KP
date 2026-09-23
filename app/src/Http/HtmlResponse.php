<?php

declare(strict_types=1);

namespace App\Http;

use Override;

class HtmlResponse extends Response
{
    public function __construct(string $content = '', int $statusCode = 200)
    {
        parent::__construct($content, $statusCode, 'text/html; charset=UTF-8');
    }
}