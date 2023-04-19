<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function ($user) {
            return $user->role == UserRole::ADMIN;
        });

        Gate::define('isEditor', function ($user) {
            return $user->role == UserRole::EDITOR;
        });

        Gate::define('isAuthor', function ($user) {
            return $user->role == UserRole::AUTHOR;
        });

        Gate::define('isPublic', function ($user) {
            return $user->role == UserRole::PUBLIC;
        });
    }
}
