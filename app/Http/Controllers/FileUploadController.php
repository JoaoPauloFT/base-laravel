<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploadController extends Controller
{
    public function FileUpload(Request $request)
    {
        try {
            $image = $request->file('file');
            $width = $request->input('width');
            $height = $request->input('height');
            $maxSize = $request->input('maxSize');
            $path = $request->input('path');

            $sizeImage = getimagesize($image);

            $imageName = explode('.', $image->getClientOriginalName())[0];
            $imageName = str_replace(array(' ', ')', '(', '/', '@', '%', '!'), '', $imageName);
            $imageName .= '_'.time().'.'.$image->extension();

            if ($maxSize) {
                if ($sizeImage[0] > $sizeImage[1]) {
                    $width = 1400;
                    $height = $sizeImage[1] * 1400 / $sizeImage[0];
                } else {
                    $height = 1400;
                    $width = $sizeImage[0] * 1400 / $sizeImage[1];
                }

                $manager = new ImageManager(new Driver());

                $image = $manager->read($image);
                $image->resize(width: $width, height: $height);

                $encoded = $image->toPng();
                $encoded->save(public_path($path.'/'.$imageName));

            } elseif ($width && $sizeImage[0] != $width && $sizeImage[1] != $height) {
                $manager = new ImageManager(new Driver());

                $image = $manager->read($image);
                $image->resize(width: $width, height: $height);

                $encoded = $image->toPng();
                $encoded->save(public_path($path.'/'.$imageName));
            } else {
                $image->move(public_path($path),$imageName);
            }


            return response()->json(
                ['data' => [
                    'locale' => asset($path.'/'.$imageName),
                    'name' => $imageName,
                    'path' => $path.'/'.$imageName
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e], 400);
        }
    }
}
