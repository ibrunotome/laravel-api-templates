<?php

namespace App\Domain\Users\Http\Requests;

use App\Interfaces\Http\Controllers\FormRequest;

class EnableTwoFactorAuthenticationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'one_time_password' => [
                'required',
                'string',
                'size:6',
            ],
        ];
    }
}
