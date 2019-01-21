<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

final class UploadDocument
{
    public static function upload(UploadedFile $file, $path, array $options = [])
    {
        try {
            $fileName = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();

            $gcs = Storage::disk('gcs');
            $filePath = $path . '/' . $fileName;
            $gcs->put($filePath, file_get_contents($file), $options);

            return $gcs->url($filePath);
        } catch (\Exception $exception) {
            Log::error(ExceptionFormat::log($exception));

            return [
                'error'   => true,
                'message' => __('Failed to upload the document, please try again')
            ];
        }
    }
}