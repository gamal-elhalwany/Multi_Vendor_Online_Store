<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = []; // Instead of fillable property.
    protected $table = 'order_items';

    public $timestamps = false; //this is used if you are not using the timestamps method in the migration file.

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => $this->product_name,
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class)->withPivot([
            'price', 'product_name'
        ]);
    }
}
