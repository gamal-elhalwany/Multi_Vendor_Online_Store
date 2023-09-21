<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category () {
        return $this->belongsTo(Category::class);
    }

    public function store () {
        return $this->belongsTo(Store::class);
    }

    // this protected function is for making or calling the global scope that we have created by this command:php artisan make:scope [nameOfScope].
    protected static function booted () {
        static::addGlobalScope('store', new StoreScope());
    }
}
