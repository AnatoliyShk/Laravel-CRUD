<?php

namespace App\Services;

use Illuminate\Foundation\Http\FormRequest;

class PostService
{
    public function provideFormRequest(FormRequest $request): array
    {
        $requestInfo = $request->validated();
        $postInfo = [
            'title' => $requestInfo['title'] ?: "",
            'description' => $requestInfo['description'] ?: ""
        ];
        if ($file = $request->file('image')) {
            $filename = (new \DateTime())->format('Y-m-d');
            $file->storeAs(
                'public',
                $filename
            );
            $postInfo['image'] = $filename;
        }
        return $postInfo;
    }
}
