<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateEntityException;
use App\Exceptions\DeleteEntityException;
use App\Exceptions\UpdateEntityException;
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
use Illuminate\Support\MessageBag;

class PostController extends Controller
{

    protected $postService;
    protected $user;

    public function __construct(User $user, PostService $postService)
    {
        $this->postService = $postService;
        $this->user = $user;
    }

    public function index()
    {
        $posts = $this->postService->getItems();
        return view('post-index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if($user = auth()->user()) {
            try {
                $post = $this->postService->create($request, $user);
                if($post === null) {
                    throw new CreateEntityException();
                }
            } catch (\Exception $exception) {
//                $exception->report();
                return back()->withErrors($exception->getMessage())->withInput();
            }
        }
        return redirect()->route('home')->with([
            'message' => 'Data success stored'
        ]);
    }

    public function destroy(DestroyRequest $destroyRequest, Post $post): RedirectResponse
    {
        try {
            $post->delete();
        } catch (\Exception $exception) {
            $exception->report();
            return back()->withErrors($exception->getMessage())->withInput();
        }
        return redirect()->route('posts.index')->with([
            'message' => 'Post success deleted'
        ]);
    }

    public function show(Post $post)
    {
        return view('post', ['post' => $post]);
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
            $post = $this->postService->update($request, $post);
            if($post === null) {
                throw new UpdateEntityException();
            }
        } catch (\Exception $exception) {
            $exception->report();
            return back()->withErrors($exception->getMessage())->withInput();
        }

        return redirect()->route('posts.index')->with([
            'message' => 'Post update success'
        ]);
    }

    protected function postResponse(Post $post): PostResource
    {
        return new PostResource($post->load('user'));
    }
}
