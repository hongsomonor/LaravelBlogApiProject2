<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'comment' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:png,jpg,jpeg,svg,gif,webp|max:15000',
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id'
        ];
    }
}
