<?php

namespace Preferred\Domain\Users\Http\Requests;

use Preferred\Domain\Users\Rules\CurrentPasswordRule;
use Preferred\Domain\Users\Rules\WeakPasswordRule;
use Preferred\Interfaces\Http\Controllers\FormRequest;

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
     *
     * @return array
     */
    public function rules()
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
