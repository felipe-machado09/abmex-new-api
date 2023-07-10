<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_id',
        'document_type',
        'document_status'
    ];




    public function scopeStatusApproved(Builder $query): void
    {
        $query->where('document_status', 'approved');
    }
}
