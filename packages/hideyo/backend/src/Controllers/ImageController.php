<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Image;

class ImageController extends Controller
{
    public function index($shopId, $type, $id, $width = false, $height = false, $image)
    {
        $path = sprintf('%s/%s/%s/%s', $shopId, $type, $id, $image);
        $base_path = storage_path();

        $img = Image::cache(function ($image) use ($base_path, $path, $width, $height) {
            $image->make($base_path.'/app/files/'.$path);

            if ($width and !$height) {
                $image->widen($width);
            }

            if ($width and $height) {
                $image->resize($width, $height);
            }

            $image->interlace();
        }, 10, true);

        return $img->response();
    }
}
