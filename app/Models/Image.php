<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JD\Cloudder\Facades\Cloudder;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function getCloudUrl()
    {
        return Cloudder::show($this->title, ["width" => "400", "height" => "225", "crop" => "scale", "quality" => 70, "secure" => "true"]);
    }
}
