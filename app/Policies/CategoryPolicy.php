<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user)
    {

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, Category $category)
    {
        //
    }
}
