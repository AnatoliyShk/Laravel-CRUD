<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public static $wrap = 'image';

    public function toArray($request): array
    {
        return [
            'title' => $this->title,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
