<?php
namespace App\Helpers;

use Carbon\Carbon;
use App\Models\FileStorage;
use Illuminate\Support\Facades\Storage;


class FilesHelper
{
    protected static $file;

    public static function init()
    {
        self::$file = FileStorage::class;

    }

    public static function getMimeType($file)
    {
        return $file->getMimeType();
    }

    public static function getExtension($file)
    {
        return $file->getClientOriginalExtension();
    }

    public static function removeBase64Header($file)
    {
        $removedBase64 = preg_replace('#^data:image/[^;]+;base64,#', '', $file);

        return $removedBase64;
    }

    public static function storeFile($file, $disk = 's3')
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        $visibility = 'private'; 

        $path = self::getPathDocuments();

        $teste = Storage::disk($disk)->putFileAs($path, $file, $fileName, [
            'visibility' => $visibility 
        ]);
    
        $url = Storage::disk($disk)->temporaryUrl($path.'/'.$fileName, now()->addMinutes(5));

        $fileStorage = FileStorage::create([
            'name' => $fileName,
            'path' => $path,
            'disk' => $disk,
            'visibility' => $visibility,
            'url' => $url,
            'size' => self::getSize($file),
            'mime_type' => self::getMimeType($file),
            'extension' => self::getExtension($file),
        ]);

        return $fileStorage;
    }

    public static function convertImgToBase64($file)
    {
        $image = file_get_contents($file);
        $base64 = base64_encode($image);

        return $base64;
    }

    public static function getPathDocuments()
    {
        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        
        return "documents/{$year}/{$month}/{$day}";
    }

    public static function getSize($file)
    {
        return $file->getSize();
    }

    public static function getDisk($file)
    {
        return $file->getDriverName();
    }

    public static function getVisibility($file)
    {
        return $file->getVisibility();
    }

    public static function getUrl($file)
    {
        return $file->url();
    }
}