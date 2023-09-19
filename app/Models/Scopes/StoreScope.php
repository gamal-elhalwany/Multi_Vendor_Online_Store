<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StoreScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // here you can put any logic you want.
        $user = auth()->user();
        if ($user->store_id) {
            $builder->where('store_id', '=', $user->store_id);
        }
    }
}
