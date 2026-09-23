<?php

declare(strict_types=1);

namespace App;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

class Container
{
    private array $bindings=[];
    
    public function bind(string $abstract, string | callable $concrete): void
    {
        $this->bindings[$abstract]=$concrete;
    }

    public function resolve(string $abstract): mixed{
        if(isset($this->bindings[$abstract])){
            $concrete= $this->bindings[$abstract];

            if(is_callable($concrete)){
                return $concrete($this);
            }
            
            $abstract=$concrete;
        }

        return $this->build($abstract);
    }

    public function build(string $class): object{
        $reflection=new ReflectionClass($class);
        if(!$reflection->isInstantiable()){
            throw new RuntimeException('Class is not instantiable');
        }

        $constructor= $reflection->getConstructor();

        if($constructor === null){
            return $reflection->newInstance();
        }

        $arguments=[];

        foreach($constructor->getParameters() as $param){
            $type= $param->getType();

            if(! $type instanceof ReflectionNamedType || $type->isBuiltin()){
                throw new RuntimeException("Cannot resolve parameter");
            }

            $arguments[]=$this->resolve($type->getName());

        }
        return $reflection->newInstanceArgs($arguments);
    }
}