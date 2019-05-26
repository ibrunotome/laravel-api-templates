<?php

namespace App\Http\Requests;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create companies');
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
                'required',
                'string',
                'max:250',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
            'max_users' => [
                'required',
                'integer',
                'between:1,32767',
            ],
        ];
    }
}
