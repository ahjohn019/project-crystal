<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreateFormRequest extends FormRequest
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
            'title' => ['required'],
            'content' => ['nullable'],
            'likes' => ['nullable'],
            'status' => ['required'],
            'category_id' => ['nullable'],
            'file' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpg,png'],
        ];
    }
}
