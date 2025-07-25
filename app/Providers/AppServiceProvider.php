<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
    
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }


        Gate::before(function ($user, $ability) {
            if (str_starts_with($ability, 'rol:')) {
                $rol = str_replace('rol:', '', $ability);
                return $user->hasRole($rol);
            }
        });
    }
}