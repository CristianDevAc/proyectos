<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Permitir validación de roles desde el menú con 'can' => 'rol:xxx'
        Gate::before(function ($user, $ability) {
            if (str_starts_with($ability, 'rol:')) {
                $rol = str_replace('rol:', '', $ability);
                return $user->hasRole($rol);
            }
        });
    }
}
