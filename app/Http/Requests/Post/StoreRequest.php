<?php

namespace App\Http\Requests\Post;

use App\Rules\Filename;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'image' => [
                'required'
            ],
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Post title is required',
            'description.required' => 'Post description is required',
            'image.required' => 'Post image is required'
        ];
    }
}
