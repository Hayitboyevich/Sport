<?php

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AddonService
{
    public function FileUploadBase64($file, $filename)
    {
        list($type, $fileData) = explode(';', $file);
        list(, $fileData) = explode(',', $fileData);
        $fileData = base64_decode($fileData);


        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $originalName = pathinfo($filename, PATHINFO_FILENAME);

        $folderPath = 'sitefile/' . Carbon::now()->format('Y-m-d') . '/';
        $fileName = Str::slug($originalName) . '_' . time() . '.' . $extension;
        $fullPath = $folderPath . $fileName;
        Storage::disk('public')->put($fullPath, $fileData);

        return $fullPath;
    }
}
