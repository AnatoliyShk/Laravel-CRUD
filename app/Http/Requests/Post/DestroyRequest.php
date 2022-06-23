<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('post')->user->id === auth()->id();
    }

    public function rules(): array
    {
        return [];
    }
}
