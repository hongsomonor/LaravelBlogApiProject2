<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $postId = $this->route('post');

        if($postId) {
            $this->merge([
                'post_id' => $postId
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => 'sometimes|string|max:255',
            'picture' => 'sometimes|image|mimes:png,jpg,jpeg,svg,webp',
            'post_id' => 'required|exists:posts,id'
        ];
    }
}
