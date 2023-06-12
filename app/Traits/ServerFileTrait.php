<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait ServerFileTrait
{
    public static function uploadServerFiles(UploadedFile $file, array $payload, $clearStorage = false): array
    {
        //
        $disk = $payload['disk'] ?? config('filesystems.default');
        $module = $payload['module_path'];
        $file_type_id = $payload['file_type_id'];
        $folderName = $payload['folder_name'] ?? 'uploads';

        $resizeImages = self::resizeImage($file, $payload['width'], $payload['height']);
        $storageDisk = Storage::disk($disk);

        if ($clearStorage == true) {
            $storageDisk->delete($folderName . '/' . $payload['server_files']->name);
        }

        $storageDisk->put($folderName . '/' . $file->hashName(), (string)$resizeImages->encode());

        $serverFileArr = [
            'name' => $file->hashName(),
            'disk' => $disk,
            'module_path' => $module,
            'file_type_id' => $file_type_id,
            'mime_type' => $file->getMimeType(),
            'extension' => $file->extension(),
            'size' => $file->getSize(),
            'ori_file' => $file->getClientOriginalName(),
            'uploadable_id' => $payload['model_id'],
        ];

        return $serverFileArr;
    }

    public static function resizeImage($file, $width, $height)
    {
        $imgFile = Image::make($file->getRealPath());
        $imgFile->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $imgFile;
    }
}
