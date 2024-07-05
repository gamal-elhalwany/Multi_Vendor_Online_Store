<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Notifications\UserCreatedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

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
        'type',
        'last_active_at',
        'provider',
        'provider_id',
        'provider_token',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public static function booted()
    {
        static::created(function ($user) {
            $user->notify(new UserCreatedNotification($user));
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'provider_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
