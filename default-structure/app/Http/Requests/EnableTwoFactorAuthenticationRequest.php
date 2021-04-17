<?php

namespace App\Http\Requests;

class EnableTwoFactorAuthenticationRequest extends FormRequest
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
            'one_time_password' => [
                'required',
                'string',
                'size:6',
            ],
        ];
    }
}
