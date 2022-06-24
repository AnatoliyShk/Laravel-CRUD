<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function getPosts(): \Illuminate\Pagination\CursorPaginator
    {
        return $this->orderBy('id', 'desc')->cursorPaginate(15);
    }

}
