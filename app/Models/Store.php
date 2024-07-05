<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'slug', 'user_id', 'description', 'logo_image', 'cover_image', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orderItem()
    {
        return $this->hasMany(orderItem::class);
    }

    public function coupon()
    {
        return $this->hasMany(Coupon::class);
    }

    protected static function booted()
    {
        static::creating(function (Store $store) {
            $store->slug = Str::slug($store->name);
        });
    }
}
