<?php

declare(strict_types=1);

use App\Exceptions\ErrorHandler;
use App\Http\Request;
use App\Routing\Dispatcher;

$container= require __DIR__ . '/container.php';

$router= require __DIR__ . '/routes.php';

$request= Request::createFromGlobals();

$dispatcher= $container->resolve(Dispatcher::class);

$errorHandler= $container->resolve(ErrorHandler::class);

return [
    'container' => $container,
    'router' => $router,
    'dispatcher' =>$dispatcher,
    'request'=> $request,
    'errorHandler' => $errorHandler
];