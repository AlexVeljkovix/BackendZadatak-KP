<?php

declare(strict_types=1);

namespace App\Routing;

use App\Exceptions\InvalidRouteException;
use App\Http\Request;

class Router
{
    private array $routes=[];

    public function register(string $method, string $route, callable|array $action): void
    {
        $this->routes[$method][$route]=$action;
    }

    public function get(string $route, callable|array $action): void
    {
        $this->register('get', $route, $action);
    }

    public function post(string $route, array $action): void
    {
        $this->register('post', $route, $action);
    }

    public function resolve(Request $request): array{

        $method=strtolower($request->method());
        $route=$request->path();

        if(! isset($this->routes[$method][$route])){
            throw new InvalidRouteException();
        }

        $action= $this->routes[$method][$route];

        return $action;
        
    }
}