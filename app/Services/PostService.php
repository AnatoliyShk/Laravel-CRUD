<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Model;

class PostService
{
    private $imageService;

    public function __construct(ImageService $imageService) {
        $this->imageService = $imageService;
    }

    public function create(FormRequest $request, ?User $relatedModel = null): ?Post
    {
        $requestInfo = $request->validated();
        $postInfo = [
            'title' => $requestInfo['title'] ?: "",
            'description' => $requestInfo['description'] ?: ""
        ];
        if($relatedModel !== null) {
            if($post = $relatedModel->posts()->create($postInfo)) {
                $this->imageService->create($request, $post);
            }
            return $post;
        }
        return null;
    }

    public function provideFormRequest(FormRequest $request, Post $post): Post
    {
        $requestInfo = $request->validated();
        $updateInfo = [
            'title' => $requestInfo['title'] ?: "",
            'description' => $requestInfo['description'] ?: ""
        ];
        if($post !== null) {
            $post->update($updateInfo);
        }
        return $post;
    }
}
