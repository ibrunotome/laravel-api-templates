<?php

namespace App\Http\Requests;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->segment(2) === 'me' ? auth()->id() : $this->segment(3);

        return auth()->user()->can('update users') || $id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignoreId = $this->segment(2) === 'me' ? auth()->id() : $this->segment(3);

        return [
            'email' => [
                'email',
                'max:250',
                'unique:users,email,' . $ignoreId,
            ],
        ];
    }
}
