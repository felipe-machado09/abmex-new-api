<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextCodeLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_id',
        'success',
        'response'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
