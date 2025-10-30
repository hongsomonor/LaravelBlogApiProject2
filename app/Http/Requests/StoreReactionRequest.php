<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReactionRequest extends FormRequest
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
            'reaction' => 'required|string|in:like,love,care,angry,sad',
            // 'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id'
        ];
    }
}
