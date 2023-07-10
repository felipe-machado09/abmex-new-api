<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, SoftDeletes};

/**
 * @property int $id
 * @property int $user_id
 * @property string $cnpj
 * @property string $fantasy_name
 * @property string $site
 * @property CurrencyEnum $currency
 * @property float $min_revenue_value
 * @property float $max_revenue_value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'cnpj',
        'fantasy_name',
        'site',
        'currency',
        'min_revenue_value',
        'max_revenue_value',
    ];

    protected $casts = [
        'min_revenue_value' => 'float',
        'max_revenue_value' => 'float',
        'currency'          => CurrencyEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
