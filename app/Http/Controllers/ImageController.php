<?php

namespace App\Http\Controllers;

use App\Exceptions\DeleteEntityException;
use App\Http\Requests\Image\DestroyRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Models\User;
use App\Services\ImageService;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    protected ImageService $postService;
    protected User $user;
    protected LoggerInterface $logger;

    public function __construct(User $user, ImageService $imageService, LoggerInterface $logger)
    {
        $this->postService = $imageService;
        $this->user = $user;
        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImageRequest  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, Image $image)
    {
        try {
            if(count($image->post->images()->get()) < 2) {
                throw new DeleteEntityException('Your post must contain at least 1 image');
            }
            $image->delete();
            Storage::delete('public/' . $image->title);
            if($image !== null) {
                throw new DeleteEntityException();
            }
        } catch (\Exception $exception) {
            $exception->report();
            return back()->withErrors($exception->getMessage())->withInput();
        }
        return redirect()->route('posts.edit', ['post' => $image->post->id])->with([
            'message' => 'Image success deleted'
        ]);
    }
}
