<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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

        Gate::define('is_applicant', function ($user) {
            return Auth::check() && $user->role === 1;
        });

        Gate::define('is_employer', function ($user) {
            return Auth::check() && $user->role === 2;
        });

        Gate::define('applicant_can', function ($user, $applicant_id) {
            return $user->data->id === $applicant_id;
        });

        Gate::define('employer_can', function ($user, $employer_id) {
            return $user->data->id === $employer_id;
        });
    }
}
