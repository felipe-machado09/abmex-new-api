<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        // dd($this->attributes['available_sell']);
        dd(ProductStatusEnum::INACTIVE);
        dd(in_array($value, [ProductStatusEnum::INACTIVE, ProductStatusEnum::BLOCKED, ProductStatusEnum::SKETCH]));

        // Lógica para definir o status de venda com base no status do produto
        if (in_array($value, [ProductStatusEnum::INACTIVE, ProductStatusEnum::BLOCKED, ProductStatusEnum::SKETCH])) {
            $this->attributes['available_sell'] = false;
        } else {
            $this->attributes['available_sell'] = true;
        }

     
    }
}