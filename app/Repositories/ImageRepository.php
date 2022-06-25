<?php


namespace App\Repositories;


use App\Models\Image;
use App\Models\Post;

class ImageRepository
{
    public function get(int $id)
    {
        return Image::where('id', $id);
    }

    public function getByPost(Post $post)
    {
        return $post->images()->get();
    }
}
