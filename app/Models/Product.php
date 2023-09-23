<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'store_id', 'image', 'category_id', 'price', 'compare_price', 'options', 'rating', 'featured', 'status',
    ];

    public function category () {
        return $this->belongsTo(Category::class);
    }

    public function store () {
        return $this->belongsTo(Store::class);
    }

    public function tags () {
        return $this->belongsToMany(
            Tag::class,     // Related Model
            'product_tag',  // Pivot Table
            'product_id',   // FK in the pivot table for the current model
            'tag_id',       // FK in the pivot table for the related model
            'id',           // Primary key Current Model
            'id',           // Primary key Related Model
        );
    }

    // this protected function is for making or calling the global scope that we have created by this command:php artisan make:scope [nameOfScope].
    protected static function booted () {
        static::addGlobalScope('store', new StoreScope());
    }
}
