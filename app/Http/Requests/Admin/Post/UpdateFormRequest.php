<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'id' => ['required'],
            'title' => ['required'],
            'content' => ['nullable'],
            'likes' => ['nullable'],
            'status' => ['required'],
            'user_id' => ['required'],
            'file' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,png'],
        ];
    }
}
