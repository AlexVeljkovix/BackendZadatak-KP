<?php

declare(strict_types=1);

namespace App\Validation;

class Validator
{
    public function validate(array $data, array $rules): ?ValidationError{
        foreach($rules as $rule){
            $error= $rule->validate($data);

            if($error !== null){
                return $error;
            }
        }

        return null;
    }
}