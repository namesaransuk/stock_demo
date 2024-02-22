<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            if ($user->isUser('am')) {
                return true;
            }
        });
        Gate::define('admin', function ($user) {
            return $user->isUser('am');
        });
        Gate::define('stock', function ($user) {
            return $user->isUser('st');
        });
        Gate::define('audit', function ($user) {
            return $user->isUser('ad');
        });
        Gate::define('production', function ($user) {
            return $user->isUser('pd');
        });
        Gate::define('procurement', function ($user) {
            return $user->isUser('pc');
        });
        Gate::define('qc', function ($user) {
            return $user->isUser('qc');
        });
        Gate::define('transport', function ($user) {
            return $user->isUser('tp');
        });
        Gate::define('accountant', function ($user) {
            return $user->isUser('ac');
        });

        //ชุดใหม่
        Gate::define('stockviewer', function ($user) {
            return $user->isUser('sv');
        });
        Gate::define('packagingsupply', function ($user) {
            return $user->isUser('ps');
        });
        Gate::define('material', function ($user) {
            return $user->isUser('mt');
        });
        Gate::define('finishproduct', function ($user) {
            return $user->isUser('fp');
        });
        Gate::define('qcmaterial', function ($user) {
            return $user->isUser('qcm');
        });
        Gate::define('qcpackaging', function ($user) {
            return $user->isUser('qcpk');
        });
        Gate::define('stockmaterial', function ($user) {
            return $user->isUser('sm');
        });
        Gate::define('stockpackaging', function ($user) {
            return $user->isUser('spk');
        });
    }
}
