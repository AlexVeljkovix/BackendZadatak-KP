<?php

declare(strict_types=1);

namespace App\Http;

class Response
{
    public function __construct(private string $content = '',
                                private int $statusCode = 200,
                                private string $contentType= 'text/html',
                               )
    {
    }

    public function send():void
    {
        http_response_code($this->statusCode);
        header("Content-Type: {$this->contentType}");
        echo $this->content;
    }
}