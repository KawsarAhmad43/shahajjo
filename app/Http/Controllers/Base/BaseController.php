<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Image;

class BaseController extends Controller
{
    /*-----IMAGE UPLOAD-----*/
    protected function upload($file, $path, $old = null, $base64 = false)
    {
        $code = date('ymdhis').'-'.rand(1111, 9999);

        /*-------DELETE OLD IMAGE-------*/
        if (! empty($old)) {
            $oldFile = $this->oldFile($old);
            if (Storage::disk('public')->exists($oldFile)) {
                Storage::delete($oldFile);
            }
        }

        /*-------FILE/IMAGE UPLOAD-------*/
        if (! empty($file) && ! $base64) {
            $fileName = $code.$file->getClientOriginalName();

            return Storage::putFileAs('upload/'.$path, $file, $fileName);
        }

        /*-------base64 IMAGE UPLOAD-------*/
        if (! empty($file) && $base64) {

            $image = str_replace('data:image/jpeg;base64,', '', $file);
            $image = str_replace(' ', '+', $image);
            $imageName = 'upload/'.$path.'/'.$code.'.png';
            Storage::disk('public')->put($imageName, base64_decode($image));

            return $imageName;
        }
    }

    /*-----OLD IMAGE-----*/
    public function oldFile($file)
    {
        $ex = explode('storage/', $file);

        return $ex[1] ?? '';
    }

    /*-----Upload Resize Image-----*/
    public function resizeImage($file, $folder, $resizeArr)
    {
        $imageUrls = [];

        $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];
        $extension = $file->getClientOriginalExtension();
        $check = in_array($extension, $allowedExt);

        $this->makeDir($folder);

        if ($check && count($resizeArr) > 0) {

            $code = date('ymdhis').'-'.rand(1111, 9999);
            $fileName = $code.$file->getClientOriginalName();

            foreach ($resizeArr as $key => $resize) {
                $this->makeDir($folder, "resize$key");

                // Resize Image Path
                $uploadPath = storage_path("app/public/upload/{$folder}/resize$key");
                $imageMake = Image::make($file->getRealPath());

                // Storage Resize Image
                $imageMake->resize($resize['width'], $resize['height'])->save($uploadPath.'/'.$fileName);

                $imageUrls += ["{$folder}$key" => "upload/photos/resize{$key}/".$fileName];
            }

            return $imageUrls;

            // $resize_image->resize( 800, 1000, function ( $constraint ) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // } )->save( $destinationPath . '/' . $fileName );

            // $resize_image->resizeCanvas( 531, 800, 'center', false, 'ff00ff' )
            //     ->save( $destinationPath . '/' . $fileName );

            // Storage Original Image
            // Storage::putFileAs( "upload/{$folder}_original", $file, $fileName );
        }
    }

    /*-----Folder Create-----*/
    public function makeDir($folder, $subfolder = null)
    {
        $main_dir = storage_path("app/public/upload/{$folder}");
        if ($subfolder) {
            $main_dir = storage_path("app/public/upload/{$folder}/{$subfolder}");
        }

        if (! file_exists($main_dir)) {
            mkdir($main_dir, 0777, true);
        }
    }
}
