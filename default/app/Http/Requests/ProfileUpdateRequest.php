<?php

namespace App\Http\Requests;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->segment(2) === 'me' ? auth()->user()->profile->id : $this->segment(3);

        return auth()->user()->can('update profiles') || $id === auth()->user()->profile->id;
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
                'max:250',
            ],
            'anti_phishing_code' => [
                'nullable',
                'alpha_dash',
                'min:4',
                'max:20',
            ],
        ];
    }
}
