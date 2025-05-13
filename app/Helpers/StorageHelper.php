<?php

namespace App\Helpers;
use Illuminate\Support\Facades\File;
class StorageHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}
    public static function deleteLocalImage($imagePath)
    {
        if (File::exists($imagePath)) {
               File::delete($imagePath);
        }
    }
}
