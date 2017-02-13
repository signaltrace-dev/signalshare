<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-project', function ($user, $project) {
            return $user->id == $project->owner_id || $user->roles->contains(1);
        });

        Gate::define('update-profile', function ($user, $profile) {
            return $user->id == $profile->user_id || $user->roles->contains(1);
        });
    }
}
