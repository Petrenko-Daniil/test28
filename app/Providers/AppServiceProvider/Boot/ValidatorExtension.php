<?php

namespace App\Providers\AppServiceProvider\Boot;
use Illuminate\Support\Facades\Validator;

class ValidatorExtension
{
    public static function handle(): void{
        Validator::extend('int_or_string', function ($attribute, $value, $parameters, $validator) {
            return (is_numeric($value) && ((int)$value == (float)$value)) || (!is_numeric($value) && is_string($value));
        });
    }
}
