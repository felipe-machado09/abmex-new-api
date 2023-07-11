<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileStorageProduct extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'file_storage_id'];

    protected $searchableFields = ['*'];

    protected $table = 'file_storage_product';

    public $timestamps = false;
}
