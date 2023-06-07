<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
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

        $storageDisk = Storage::disk($disk);

        if ($clearStorage == true) {
            $storageDisk->delete($folderName . '/' . $payload['server_files']->name);
        }

        $storageDisk->put($folderName, $file);

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
}
