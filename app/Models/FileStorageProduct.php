<?php

namespace App\Models;

use App\Models\Product;
use App\Models\FileStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileStorageProduct extends Model
{
    use HasFactory;

    protected $table = 'file_storage_products';

    protected $fillable = [
        'file_id',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function file()
    {
        return $this->belongsTo(FileStorage::class);
    }
    
}
