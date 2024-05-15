<?php

namespace App\Traits;

use Carbon\CarbonTimeZone;
use Stevebauman\Location\Facades\Location;


trait FileUploadTrait
{
    
    public function imageUpload($image, $folderName)
    {
        try {
            return $image->store($folderName, 'public');
        } catch (\Throwable $th) {
            return 'File upload Error';
        }
        
    }

    
}
