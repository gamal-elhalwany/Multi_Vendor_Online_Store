<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'description',
        'image',
        'status',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent () {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products () {
        return $this->hasMany(Product::class);
    }

    // Example For Local Scope for this Model and Filtering Data.
    public function scopeFilter (Builder $builder, $filters) {
        $builder->when($filters['name'] ?? false, function($builder, $name) {
            $builder->where('name', 'LIKE', "%$name%");
        });

        $builder->when($filters['status'] ?? false, function($builder, $status) {
            $builder->where('status', '=', $status);
        });
    }
}
