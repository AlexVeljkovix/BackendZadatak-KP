<?php

declare(strict_types=1);

use App\Middleware\CsrfMiddleware;

require_once __DIR__ . '/../../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../views');

[
    'container' => $container,
    'router' => $router,
    'request' => $request,
    'dispatcher' => $dispatcher,
    'errorHandler' => $errorHandler
] = require __DIR__ . '/../bootstrap/app.php';


try{

    $action=$router->resolve($request);

    $response = $dispatcher->dispatch($action, $request);

}catch(Throwable $exception){
    $response = $errorHandler->handle($exception);
}

$response->send();
