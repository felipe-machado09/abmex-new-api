<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Enums\OnboardEnum;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $phone_number
 * @property Carbon $terms_accepted_at
 * @property string $terms_subject
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'terms_accepted_at',
        'terms_subject',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'terms_accepted_at' => 'datetime',
        'password' => 'hashed'
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function bank(): HasOne
    {
        return $this->hasOne(Bank::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public function document(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function nextCodeLog(): HasMany
    {
        return $this->hasMany(NextCodeLogs::class);
    }
    public function getFinishedOnboardingAttribute()
    {
        return $this->hasApprovedDocuments()->exists();
    }

    public function getOnboardStageAttribute() : OnboardEnum
    {
        return $this->finishedOnboarding ? OnboardEnum::INDOOR : OnboardEnum::ONBOARD;
    }


    public function scopeHasApprovedDocuments(Builder $query): void
    {
        $query->whereHas('document', function ($query) {
            $query->whereIn('document_type', ['rg', 'cnh'])
                ->statusApproved();
        });
    
        $query->whereHas('document', function ($query) {
            $query->where('document_type', 'social_contract')
                ->statusApproved();
        });
    }

}