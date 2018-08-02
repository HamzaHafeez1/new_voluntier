<?php

namespace App\Services;

use Image;

class ImageExif
{
    public function exif($file){
        $exif = exif_read_data($file);
        $newImage = Image::make($file);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 3: {
                    $newImage->rotate(180);
                    break;
                }
                case 6: {
                    $newImage->rotate(-90);
                    break;
                }
                case 8: {
                    $newImage->rotate(90);
                    break;
                }
            }

            return $newImage;
        }

        return false;
    }
}