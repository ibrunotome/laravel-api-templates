<?php

namespace App\Domain\Users\Http\Requests;

use App\Domain\Users\Rules\CurrentPasswordRule;
use App\Domain\Users\Rules\WeakPasswordRule;
use App\Interfaces\Http\Controllers\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                new CurrentPasswordRule(),
            ],
            'password'         => [
                'required',
                'confirmed',
                'min:8',
                new WeakPasswordRule(),
            ],
        ];
    }
}
