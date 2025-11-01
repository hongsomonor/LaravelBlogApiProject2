<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 
    }

    protected function prepareForValidation()
    {
        // Get the ID from the URL path (e.g., /post/5/comment -> '5')
        $postId = $this->route('post');

        if($postId) {
            // MERGE this ID into the request data.
            $this->merge([
                'post_id' => $postId
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:png,jpg,jpeg,svg,gif,webp|max:15000',
            // The rules run against the *merged* request data,
            // so 'post_id' is present and can be validated.
            'post_id' => 'required|exists:posts,id'
        ];
    }
}
