<?php

namespace App\Models;

use App\Models\FileStorage;
use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @property int id
 * @property string name
 * @property int user_id
 * @property string description
 * @property bool available_sell
 * @property string status
 * @property string created_at
 * @property string updated_at
 * @property User user
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'status',
        'available_sell'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsToMany(FileStorage::class, 'file_storage_products', 'product_id', 'file_id');
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;

        if (in_array(
            $value,
            [
            ProductStatusEnum::INACTIVE->value,
            ProductStatusEnum::BLOCKED->value,
            ProductStatusEnum::SKETCH->value]
        )) {
            $this->attributes['available_sell'] = false;
        }

    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }
}
