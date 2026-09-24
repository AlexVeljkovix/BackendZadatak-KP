<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    public function __construct(
        private array $body,
        private string $method,
        private string $uri
    ){
    }

    public static function createFromGlobals():static{
        $body = $_POST;
        $body['ip']= $_SERVER['REMOTE_ADDR'] ?? '';

        return new static(
            $body,
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );
    }

    public function method(): string{
        return $this->method;
    }

    public function uri(): string{
        return $this->uri;
    }

    public function path():string{
        return parse_url($this->uri(), PHP_URL_PATH);
    }

    public function body():array{
        return $this->body;
    }
}