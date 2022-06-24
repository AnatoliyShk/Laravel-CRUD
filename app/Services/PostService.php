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
            'description' => $requestInfo['description'] ?: "",
            'isImageUpdate' => false
        ];
        if ($file = $request->file('image')) {
            $filename = (new \DateTime())->format('Y-m-d h:i:s');
            $isCreated = $file->storeAs(
                'public',
                $filename
            );
            if($isCreated === true || is_string($isCreated)) {
                $postInfo['isImageUpdate'] = true;
            }
            $postInfo['image'] = $filename;
        }
        return $postInfo;
    }
}
