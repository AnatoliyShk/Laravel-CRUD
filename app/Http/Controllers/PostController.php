<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\DestroyRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Psr\Log\LoggerInterface;

class PostController extends Controller
{

    protected PostService $postService;
    protected Post $post;
    protected User $user;
    protected LoggerInterface $logger;

    public function __construct(Post $post, User $user, PostService $postService, LoggerInterface $logger)
    {
        $this->postService = $postService;
        $this->post = $post;
        $this->user = $user;
        $this->logger = $logger;
    }

    public function index()
    {
        return view('post-index', ['posts' => $this->post->getPosts()]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        if($user = auth()->user()) {
            try {
                $createInfo = $this->postService->provideFormRequest($request);
                $user->posts()->create($createInfo);
                $notification = [
                    'status' => 'success',
                    'message' => 'Data success stored'
                ];
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                $notification = [
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ];
            }
        } else {
            $notification = [
                'status' => 'error',
                'message' => 'Something went wrong'
            ];
        }
        return redirect()->route('home')->with($notification);
    }

    public function destroy(DestroyRequest $destroyRequest, Post $post): RedirectResponse
    {
        try {
            $destroyRequest->validated();
            $post->delete();
            $notification = [
                'status' => 'success',
                'message' => 'Post success deleted'
            ];
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $notification = [
                'status' => 'error',
                'message' => 'Something went wrong'
            ];
        }
        return redirect()->route('posts.index')->with($notification);
    }

    public function show(Post $article): PostResource
    {
        return $this->postResponse($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($user = auth()->user()) {
            return view('post-edit', ['post' => $post]);
        }
        return view('auth.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Post\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return RedirectResponse
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        try {
            $updateInfo = $this->postService->provideFormRequest($request);
            if ($updateInfo['isImageUpdate'] && $post->image) {
                Storage::delete('public/' . $post->image);
            }
            $post->update($updateInfo);
            $notification = [
                'status' => 'success',
                'message' => 'Post update success'
            ];
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $notification = [
                'status' => 'error',
                'message' => 'Something went wrong'
            ];
        }

        return redirect()->route('posts.index')->with($notification);
    }

    protected function postResponse(Post $post): PostResource
    {
        return new PostResource($post->load('user'));
    }
}
