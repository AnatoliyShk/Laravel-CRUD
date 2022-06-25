<?php


namespace App\Repositories;


use App\Models\Post;

class PostRepository implements RepositoryInterface
{
    public function get(int $id)
    {
        return Post::where('id', $id);
    }

    public function getItems()
    {
        return Post::orderBy('updated_at', 'desc')->paginate(3);
    }
}
