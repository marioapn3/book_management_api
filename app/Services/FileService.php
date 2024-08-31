<?php

namespace App\Services;

use App\Exceptions\FileUploadException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadFile($file, $path = 'file')
    {
        try {
            $fileName = Str::random(60);
            $extension = $file->getClientOriginalExtension();
            $pathName = '/storage/' . $path . '/' . $fileName . '.' . $extension;
            Storage::put('/public/' . $path . '/' . $fileName . '.' . $extension, File::get($file));
            Log::info('File uploaded successfully', ['path' => $pathName, 'file' => $file, 'extension' => $extension]);
            return $pathName;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }


    public function removeFile($path)
    {
        $path = str_replace('/storage', 'public', $path);

        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}
