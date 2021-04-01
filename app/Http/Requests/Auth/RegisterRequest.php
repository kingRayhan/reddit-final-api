<?php

namespace App\Http\Requests\Auth;

use App\Rules\AllLowerCase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'username' => ['required', 'min:3', 'max:50', Rule::unique('users'), new AllLowerCase()],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'min:6', 'confirmed']
        ];
    }
}
