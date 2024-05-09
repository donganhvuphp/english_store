<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class HandleFileService
{
    /**
     * @param $fileContent
     * @param string $disk
     * @param string $directory
     * @param string $fileName
     * @return string
     */
    public function saveFile($fileContent, string $disk = 'public', string $directory = 'audio', string $fileName = ''): string
    {
        if (empty($fileName)) {
            $fileName = $this->generateFileName();
        }

        Storage::disk($disk)->put("$directory/$fileName", $fileContent);

        return asset(Storage::disk($disk)->url("$directory/$fileName"));
    }

    /**
     * @return string
     */
    public function generateFileName(): string
    {
        return uniqid() . '.mp3';
    }
}
