<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'admin@mail.com') && $this->hasVerifiedEmail();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];
/**
 * Get the subDistrict that owns the User
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */

// public function subDistrict(){
//     return $this->belongsTo(SubDistrict::class);
// }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    /**
     * Get all of the payments fer
     *
     * @return \Illuminate\DatabPaymentRequestquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(PaymentRequest::class);
    }
    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }
    public function withdraws()
    {
        return $this->hasMany(WithdrawRequest::class);
    }
}