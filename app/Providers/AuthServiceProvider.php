<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        Gate::define('voir-admin', function (User $user) {
            return $user->role->name === 'Administrateur';
        });
        Gate::define('voir-super-admin', function (User $user) {
            return $user->role->name === 'Super Administrateur';
        });

        Gate::define(
            'voir-utilisateur',
            function (User $user) {
                return $user->role->name === 'Utilisateur';
            }
        );
    }
}
