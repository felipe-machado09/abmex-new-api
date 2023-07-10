<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function bankList()
    {
        return Storage::disk('public')->get('banks/banks.json');
    }
}
