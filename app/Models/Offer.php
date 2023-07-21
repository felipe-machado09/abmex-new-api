<?php

namespace App\Models;

use Database\Factories\OfferFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int id
 * @property int product_id
 * @property string name
 * @property float price
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon|null deleted_at
 * @property Product product
 */

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'recurrency_setup',
        'pages_setup',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory(): Factory
    {
        return OfferFactory::new();
    }
}
