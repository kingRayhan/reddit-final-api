<?php

namespace App\Http\Requests\Thread;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateThreadRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'url', 'max:255'],
            'text' => ['nullable', 'min:10'],
            'type' => ['required', Rule::in(['LINK', 'TEXT'])]
        ];
    }
}
