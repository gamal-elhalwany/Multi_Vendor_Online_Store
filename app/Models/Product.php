<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'store_id', 'image', 'category_id', 'price', 'compare_price', 'options', 'rating', 'featured', 'status',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'image'];

    // this is how you can append the accessors to the response of api.
    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            // this is used if there is a many to many relationship.
            Tag::class,     // Related Model
            'product_tag',  // Pivot Table
            'product_id',   // FK in the pivot table for the current model
            'tag_id',       // FK in the pivot table for the related model
            'id',           // Primary key Current Model
            'id',           // Primary key Related Model
        );
    }

    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            'order_items',
            'product_id',
            'order_id',
            'id',
            'id'
        )->withPivot(
            [
                'product_name', 'price', 'quantity', 'options',
            ]
        );
    }

    // this protected function is for making or calling the global scope that we have created by this command:php artisan make:scope [nameOfScope].
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $name) {
            $builder->where('name', 'LIKE', "%$name%");
        });

        $builder->when($filters['price'] ?? false, function ($builder, $price) {
            $builder->where('price', 'LIKE', "%$price%");
        });
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }


    // Accessors: these accessors are made for making changes on the DB attributes when we access them and we call its names like this as below example [image_url], it makes some operations on the DB attribute and return it back.
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['https://', 'http:/'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentageAttribute()
    {
        if (!$this->compare_price) {
            return;
        }
        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }

    public function scopeFilters(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });

        $builder->when($options['status'], function ($builder, $value) {
            $builder->where('status', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$value]);
        });
    }
}
