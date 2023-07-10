<?php

namespace App\Traits;

use App\Enums\DocumentStatusEnum;
use App\Models\Document;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\NextCodeLogs;
use App\Enums\DocumentTypeEnum;
use Illuminate\Support\Facades\Http;

trait NextCodeTrait
{
    protected static $apiKey;
    protected static $apiUrl;
    protected static $ocrV4;


    protected static function initializeNextCode()
    {
        self::$apiKey = config('nextcode.api_key');
        self::$apiUrl = config('nextcode.api_url');
        self::$ocrV4 = config('nextcode.ocr_v4');
    }

    public static function checkDocument($document, $user)
    {
        self::initializeNextCode(); 
        $urlOcr4 = self::$apiUrl . self::$ocrV4;
        $requestData = [];
        $requestData['urls']['fileName'] = $document->url;
        $documentType = null;

        $response = Http::withHeaders([
            'Authorization' => 'ApiKey '. self::$apiKey,
        ])->post($urlOcr4, $requestData)->json();

        $success = !empty($response['data']);

        if ($success) {
            $documentType = self::getDocumentType($response);
        }

        $nextCodeLog = NextCodeLogs::create([
            'user_id' => $user->id,
            'file_id' => $document->id,
            'success' => $success,
            'response' => json_encode($response),
        ]);

        $document = Document::create([
            'user_id' => $user->id,
            'file_id' => $document->id,
            'document_type' => $documentType,
            'document_status' => $success ? DocumentStatusEnum::APPROVED : DocumentStatusEnum::REJECTED,
        ]);

        return $success ? DocumentStatusEnum::APPROVED : DocumentStatusEnum::REJECTED;
    }

    public static function getDocumentType($document)
    {
        $documentType = null;
        $data = Arr::get($document, 'data.0.enhanced.schemaName');

        if (Str::contains($data, 'driversLicense')) {
            $documentType = DocumentTypeEnum::CNH;
        } elseif (Str::contains($data, 'federalID')) {
            $documentType = DocumentTypeEnum::RG;
        }

        return $documentType;
    }
}
