<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\FileStorage;

use App\Enums\DocumentTypeEnum;
use App\Enums\DocumentStatusEnum;
use Illuminate\Support\Facades\Storage;
use BenSampo\Enum\Enum;

trait FilesTrait
{
    protected static $file;

    protected static function initializeFilesHelper()
    {
        self::$file = FileStorage::class;
    }


    public function getMimeType($file)
    {
        return $file->getMimeType();
    }

    public function getExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    public function removeBase64Header($file)
    {
        $removedBase64 = preg_replace('#^data:image/[^;]+;base64,#', '', $file);

        return $removedBase64;
    }

    public function storeFile($file, $disk = 's3') 
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        $visibility = 'private';

        $path = $this->getPathDocuments();

        Storage::disk($disk)->putFileAs($path, $file, $fileName, [
            'visibility' => $visibility
        ]);

        $url = Storage::disk($disk)->temporaryUrl($path . '/' . $fileName, now()->addMinutes(5));

        $fileStorage = FileStorage::create([
            'name' => $fileName,
            'path' => $path,
            'disk' => $disk,
            'visibility' => $visibility,
            'url' => $url,
            'size' => $this->getSize($file),
            'mime_type' => $this->getMimeType($file),
            'extension' => $this->getExtension($file),
        ]);

        return $fileStorage;
    }


    public function assignFileToUser(FileStorage $file, User $user, DocumentTypeEnum $type) : ?User 
    {
        if(isset($file)){
            $user->document()->create([
                'file_id' => $file->id,
                'document_type' => $type,
                'document_status' => DocumentStatusEnum::APPROVED
            ]);
            return $user;
        }
        return null;     
    }

    

    public function convertImgToBase64($file)
    {
        $image = file_get_contents($file);
        $base64 = base64_encode($image);

        return $base64;
    }

    public function getPathDocuments()
    {
        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        return "documents/{$year}/{$month}/{$day}";
    }

    public function getSize($file)
    {
        return $file->getSize();
    }

    public function getDisk($file)
    {
        return $file->getDriverName();
    }

    public function getVisibility($file)
    {
        return $file->getVisibility();
    }

    public function getUrl($file)
    {
        return $file->url();
    }
}
