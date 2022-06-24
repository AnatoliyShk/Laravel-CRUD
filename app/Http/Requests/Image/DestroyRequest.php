<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('image')->post->user->id === auth()->id();
    }

    public function rules(): array
    {
        return [];
    }
}
