<?php

namespace App\Helpers;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageHelper
{
    public static function resizeImage($file)
    {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $fileStoredPath = $file->storeAs('covers', $filename, 'public');
        $path = storage_path('app/public/covers/' . $filename);
        $manager = new ImageManager(new Driver());
        $image = $manager->read($path);
        
        $width = $image->width();
        $height = $image->height();
        
        $newWidth = 200;
        $newHeight = ($height / $width) * $newWidth;
        
        $image->resize(width: $newWidth, height: (int)$newHeight);
        
        $image->save($path);
        $validated['cover'] = 'covers/' . $filename;

        return $fileStoredPath;
    }
}
