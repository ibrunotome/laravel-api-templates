<?php

namespace App\Interfaces\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use App\Application\Exceptions\FormValidationException;

class FormRequest extends LaravelFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new FormValidationException($validator);
    }
}
