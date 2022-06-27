<?php


namespace App\Services;

use App\Models\Post;
use App\Repositories\ImageRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Collection;
use JD\Cloudder\Facades\Cloudder;

class ImageService
{

    private $imageRepository;

    public function __construct(ImageRepository $imageRepository) {
        $this->imageRepository = $imageRepository;
    }

    public function create(FormRequest $request, ?Post $relatedModel = null): ?Collection {
        if (($files = $request->file('image')) && $relatedModel !== null) {
            foreach ($files as $key => $file) {
                $time = (new \DateTime())->format('Y-m-d h:i:s');
                $filename = $file->getRealPath();
                $cloudFile = Cloudder::upload($filename, null, array(
                    "folder" => "laravel",  "overwrite" => FALSE,
                    "resource_type" => "image", "responsive" => TRUE, "transformation" => array("quality" => "100", "width" => "450", "height" => "450", "crop" => "scale")
                ));
                $publicId = Cloudder::getPublicId();
                if ($cloudFile !== null) {
                    $relatedModel->images()->create(['title' => $publicId]);
                }
            }
        }
        return $this->imageRepository->getByPost($relatedModel);
    }
}
