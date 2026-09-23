<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\HtmlResponse;
use App\Http\JsonResponse;
use App\Http\Request;
use App\Http\Response;
use App\Services\RegistrationService;
use App\Validation\RegistrationRules;
use App\Validation\Validator;
use App\View;
use RuntimeException;

class RegistrationController
{
    public function __construct(private Validator $validator, 
                                private RegistrationRules $registrationRules, 
                                private RegistrationService $registrationService)
    {
    }

    public function show(): HtmlResponse
    {
        $view = View::show('registration/register'); 
        return new HtmlResponse($view->render());
    }

    public function register(Request $request): JsonResponse
    {
        $data= $request->all();

        $rules= $this->registrationRules->rules();

        $error= $this->validator->validate($data, $rules);

        if($error !== null){
            return new JsonResponse(['success' => false, 'field' => $error->field, 'error' => $error->code], 422);
        }

        $userId = $this->registrationService->register($data['email'], $data['password']);

        return new JsonResponse(['success' => true, 'userId' => $userId], 201);
    }

    public function success(): HtmlResponse
    {
        $view = View::show('registration/success'); 
        return new HtmlResponse($view->render());
    }
    
}