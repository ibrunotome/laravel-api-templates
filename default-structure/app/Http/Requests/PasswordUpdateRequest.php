<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordRule;
use App\Rules\WeakPasswordRule;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
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
