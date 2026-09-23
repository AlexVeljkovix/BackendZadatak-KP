<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    public function __construct(
        private array $query,
        private array $body,
        private string $method,
        private string $uri
    ){
    }

    public static function createFromGlobals():static{
        return new static(
            $_GET,
            $_POST,
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );
    }

    public function query(string $key, mixed $default=null):mixed
    {
        return $this->query[$key]?? $default;
    }

    public function input(string $key, mixed $default=null):mixed
    {
        return $this->body[$key]?? $default;
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

    public function all():array{
        return $this->body;
    }

}