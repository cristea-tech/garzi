<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // definesc porti pentru fiecare tip de utilizator
        Gate::define('isAdmin', function($user){
            return $user->tip === 'Admin';
        });
        Gate::define('isAuthor', function($user){
            return $user->tip === 'Author';
        });
        Gate::define('isUser', function($user){
            return $user->tip === 'User';
        });


        Passport::routes();
        //
    }
}
