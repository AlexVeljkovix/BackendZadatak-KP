<?php

declare(strict_types=1);

use App\Controllers\RegistrationController;
use App\Routing\Router;

$router=new Router();

$router->get('/register', [RegistrationController::class, 'show']);

$router->post('/register', [RegistrationController::class, 'register']);

$router->get('/registration/success', [RegistrationController::class, 'success']);

return $router;