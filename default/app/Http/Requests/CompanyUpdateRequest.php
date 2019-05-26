<?php

namespace App\Http\Requests;

class CompanyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update companies');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => [
                'string',
                'max:250',
            ],
            'is_active' => [
                'boolean',
            ],
            'max_users' => [
                'integer',
                'between:1,32767',
            ],
        ];
    }
}
