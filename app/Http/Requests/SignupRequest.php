<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'confirmed',
                'unique:users,email',
                'ends_with:xcelsior.lv'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(5)
                ->letters()
                ->symbols()
            ],
            'user_location' => 'required',
        ];
    }
}
