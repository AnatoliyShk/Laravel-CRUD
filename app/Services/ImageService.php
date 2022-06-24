<?php


namespace App\Services;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Collection;

class ImageService
{
    public function create(FormRequest $request, ?Post $relatedModel = null): ?Collection {
        if (($files = $request->file('image')) && $relatedModel !== null) {
            foreach ($files as $key => $file) {
                $filename = (new \DateTime())->format('Y-m-d h:i:s');
                $isCreated = $file->storeAs(
                    'public',
                    $key.$filename
                );
                if ($isCreated) {
                    $relatedModel->images()->create(['title' => $key.$filename]);
                }
            }
        }
        return $relatedModel->images()->get();
    }
}
