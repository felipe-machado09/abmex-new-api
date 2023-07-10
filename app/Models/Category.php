<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\CategoryEnum;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $category_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'name',
        'type',
        'category_id',
    ];

    protected $with = ['parent'];

    protected $casts = [
        'type' => CategoryEnum::class,
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

     
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
