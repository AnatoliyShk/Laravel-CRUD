<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Model;

class PostService
{
    private $imageService;
    private $postRepository;

    public function __construct(PostRepository $postRepository, ImageService $imageService) {
        $this->imageService = $imageService;
        $this->postRepository = $postRepository;
    }

    public function getItems()
    {
        return $this->postRepository->getItems();
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

    public function update(FormRequest $request, Post $post): Post
    {
        $requestInfo = $request->validated();
        $updateInfo = [
            'title' => $requestInfo['title'] ?: "",
            'description' => $requestInfo['description'] ?: ""
        ];
        if($post !== null) {
            $post->update($updateInfo);
            $this->imageService->create($request, $post);
        }
        return $post;
    }
}
