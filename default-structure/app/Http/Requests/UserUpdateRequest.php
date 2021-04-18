<?php

namespace App\Http\Requests;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $id = $this->segment(2) === 'me' ? $this->user()->id : $this->segment(3);

        return $this->user()->can('update users') || $id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $ignoreId = $this->segment(2) === 'me' ? $this->user()->id : $this->segment(3);

        return [
            'email'              => [
                'email',
                'max:250',
                'unique:users,email,' . $ignoreId,
            ],
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
