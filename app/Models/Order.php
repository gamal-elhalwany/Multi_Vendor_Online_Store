<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'store_id', 'user_id', 'number', 'status', 'payment_status', 'payment_method',
    ];

    public function store () {
        return $this->belongsTo(Store::class);
    }

    public function user () {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer',
        ]);
    }

    public function orderItems ()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addresses ()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress ()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
        ->where('type', '=', 'billing');
    }

    public function shippingAddress ()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
        ->where('type', '=', 'shipping');
    }

    public function products () {
        return $this->belongsToMany(Product::class, 'order_id', 'id')
        ->withPivot([
            // this used if you have a pivot table with additional columns more than the foreign ids.
            'product_name', 'price', 'quantity', 'options',
        ]);
    }

    public function payments () {
        return $this->hasMany(Payment::class);
    }

    protected static function booted()
    {
//these functions is used with Observers but we used it here without creating an Observer File.
        static::creating(function (Order $order) {
            $order->number = Order::getOrderNextNumber();
        });
    }

    public static function getOrderNextNumber () {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');

        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
