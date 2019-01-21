<?php

namespace Preferred\Domain\Users\Http\Requests;

use Preferred\Interfaces\Http\Controllers\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name'               => [
                'string',
                'max:250'
            ],
            'anti_phishing_code' => [
                'nullable',
                'alpha_dash',
                'min:4',
                'max:20'
            ],
        ];
    }
}
