<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Exceptions\FormValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FormValidationException($validator);
    }
}
