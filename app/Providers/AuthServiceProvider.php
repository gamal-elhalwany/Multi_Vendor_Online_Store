<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate::define('category.view', function ($user) {
        //     return false;
        // });

        // Gate::define('category.create', function ($user) {
        //     return true;
        // });

        // Gate::define('category.update', function ($user) {
        //     return false;
        // });

        // Gate::define('category.delete', function ($user) {
        //     return false;
        // });

        // Gate::before(function ($user){
        //     if ($user->super_admin) {
        //         return true;
        //     }
        // });

    }

}
