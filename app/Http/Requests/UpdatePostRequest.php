<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:10|max:255',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
            'delete_image' => 'nullable|boolean',
        ];
    }
}
