<?php

declare(strict_types=1);

namespace App\Routing;

use App\Container;
use App\Http\Request;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use RuntimeException;

class Dispatcher
{
    public function __construct(
        private Container $container
    )
    {
    }

    public function dispatch(array $action, Request $request): mixed{
        [$class, $method]= $action;
        
        $controller= $this->container->resolve($class);

        $reflection=new ReflectionMethod($controller, $method);

        $arguments=[];

        foreach($reflection->getParameters() as $param){
            $type= $param->getType();

            if(! $type instanceof ReflectionNamedType || $type->isBuiltin()){
                throw new RuntimeException("Cannot resolve parameter.");
            }

            if($type->getName() === Request::class){
                $arguments[]=$request;
                continue;
            }

            $arguments[]=$this->container->resolve($type->getName());
        }

        return $reflection->invokeArgs($controller, $arguments); 
    }
}